/**
 * recover.c
 *
 * Computer Science 50
 * Problem Set 4
 *
 * Recovers JPEGs from a forensic image.
 */
#include <stdio.h>
#include <cs50.h>
#include <stdlib.h>
#include <stdint.h>

int main(int argc, char* argv[])
{
    FILE* cf = fopen("card.raw", "r");
    
    // ensures the file was opened successfully
    if (cf == NULL)
    {
        printf("Could not open the file.");
        return 1;
    }
    
    // keeps track on how many images have been generated
    int imgnum = 0;
    
    // creates a buffer of the size of a block and stores 8-bit unsigned ints
    uint8_t buffer[512];
    
    // initilializes the file that will be written to for each .jpg
    FILE* newjpg;
    
    // iterates through the .raw file one 512 byte block at a time and reads it
    while (fread(buffer, 512, 1, cf) > 0)
    {
        // checks to see if the first 4 bytes are a .jpg signature
        if (buffer[0] == 0xff && buffer[1] == 0xd8 && buffer[2] == 0xff && 
        (buffer[3] == 0xe0 || buffer[3] == 0xe1))
        {   
            // if a file is already open, it will be closed
            if (imgnum > 0)
            {
                fclose(newjpg);
            }
            
            // a new file will be opened with the name ###.jpg where ### is the
            // current imgnum; if this is the first .jpg, fileOpen becomes 1
            char name[7];
            sprintf(name, "%03d.jpg", imgnum);
            newjpg = fopen(name, "w");
            imgnum++;
        }
        
        // if a file is currently open, the read block wil be written to it
        if (imgnum > 0)
        {
            fwrite(buffer, 512, 1, newjpg);
        }
    }
    
    // once the loop has completed, all files will be closed, freeing memory
    fclose(cf);
    fclose(newjpg);
    return 0;
}
