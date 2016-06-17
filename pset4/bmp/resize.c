/**
 * resize.c
 *
 * Computer Science 50
 * Problem Set 4
 *
 * Resize a BMP, just because.
 */
       
#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>

#include "bmp.h"

int main(int argc, char* argv[])
{
    // ensure proper usage
    if (argc != 4)
    {
        printf("Usage: ./copy factor infile outfile\n");
        return 1;
    }

    // remember filenames
    char* infile = argv[2];
    char* outfile = argv[3];

    // accepts scaling factor
    int n = atoi(argv[1]);
    if (n < 1 || n > 100)
    {
        printf("Select an integer between 1 and 100.");
        return 2;
    }
    
    // open input file 
    FILE* inptr = fopen(infile, "r");
    if (inptr == NULL)
    {
        printf("Could not open %s.\n", infile);
        return 3;
    }

    // open output file
    FILE* outptr = fopen(outfile, "w");
    if (outptr == NULL)
    {
        fclose(inptr);
        fprintf(stderr, "Could not create %s.\n", outfile);
        return 4;
    }

    // read infile's BITMAPFILEHEADER
    BITMAPFILEHEADER bf;
    fread(&bf, sizeof(BITMAPFILEHEADER), 1, inptr);
    BITMAPFILEHEADER newbf = bf;

    // read infile's BITMAPINFOHEADER
    BITMAPINFOHEADER bi;
    fread(&bi, sizeof(BITMAPINFOHEADER), 1, inptr);
    BITMAPINFOHEADER newbi = bi;

    // ensure infile is (likely) a 24-bit uncompressed BMP 4.0
    if (bf.bfType != 0x4d42 || bf.bfOffBits != 54 || bi.biSize != 40 || 
        bi.biBitCount != 24 || bi.biCompression != 0)
    {
        fclose(outptr);
        fclose(inptr);
        fprintf(stderr, "Unsupported file format.\n");
        return 4;
    }

    // calculates dimensions of resized image
    newbi.biHeight = 0xffffffff - abs(bi.biHeight) * n + 0x01;
    newbi.biWidth = bi.biWidth * n;
    
    // calculates padding required for resized image and padding for scanlines
    int newpadding = (4 - (newbi.biWidth * sizeof(RGBTRIPLE)) % 4) % 4;
    int padding =  (4 - (bi.biWidth * sizeof(RGBTRIPLE)) % 4) % 4;
    
    // calculates sizes of resized image
    newbi.biSizeImage = (newbi.biWidth * sizeof(RGBTRIPLE) + newpadding) * 
    abs(newbi.biHeight);
    newbf.bfSize = 0x36 + newbi.biSizeImage;

    // writes the new BITMAPFILEHEADER to the output file
    fwrite(&newbf, sizeof(BITMAPFILEHEADER), 1, outptr);

    // write the new BITMAPINFOHEADER to the output file
    fwrite(&newbi, sizeof(BITMAPINFOHEADER), 1, outptr);
    
    // iterate over infile's scanlines
    for (int i = 0, biHeight = abs(bi.biHeight); i < biHeight; i++)
    {
        // keeps track of how many times a row has been written
        int counter = 1;
        
        // writes each row n times
        for (int k = 0; k < n; k++)
        {
            // iterate over pixels in scanline
            for (int j = 0; j < bi.biWidth; j++)
            {
                // temporary storage
                RGBTRIPLE triple;

                // read RGB triple from infile
                fread(&triple, sizeof(RGBTRIPLE), 1, inptr);
                
                // will write each pixel n times in succession along a row
                for (int l = 0; l < n; l++)
                {
                    // write RGB triple to outfile
                    fwrite(&triple, sizeof(RGBTRIPLE), 1, outptr);
                }
            }
            
            // adds the new padding
            for (int k = 0; k < newpadding; k++)
            {
                fputc(0x00, outptr);
            }
            
            // will return to beginning of input line n - 1 more times, in
            // effect writing the pixel n times along a column as well
            if (counter < n)
            {
                fseek(inptr, -bi.biWidth * sizeof(RGBTRIPLE), SEEK_CUR);
            }
            counter++;
        }
        
        // skip over padding, if any
        fseek(inptr, padding, SEEK_CUR);
    }

    // close infile
    fclose(inptr);

    // close outfile
    fclose(outptr);

    // that's all folks
    return 0;
}
