#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <ctype.h>

int main(int argc, string argv[])
{
    // if 0 or multiple keys are entered, the program will won't run
    if (argc != 2)
    {
        printf("You have to enter exactly one keyword.\n");
        return 1;
    }
    
    // if the key contains anything that's not a letter, it won't run
    string key = argv[1];
    for (int j = 0; j < strlen(key); j++)
    {
        if (!isalpha(key[j]))
        {
            printf("Keyword must only contain letters A-Z and a-z\n");
            return 1;
        }
    }
    
    // counter increases every time a non-alphabetic character is encountered
    int counter = 0;
    string input = GetString();
    int inlen = strlen(input);
    int keylen = strlen(key);
    
    // capitalizes all letters of the key to place them between 65 and 90
    for (int k = 0; k < keylen; k++)
    {
        key[k] = toupper(key[k]);
    }
        
    // cipher operates on each letter of the input
    for (int i = 0; i < inlen; i++)
    {
        // the letter shift changes to the next "key" char for each "input" char
        // after the last letter, mod loops it back to the beginning of "key"
        // subtracting "counter" prevents moving on to the next "key" char
        int move = key[((i - counter) % keylen)] - 65;
        
        // if the letter is lowercase, the program will find the corresponding
        // lowercase letter (loops between 97 and 122)
        if (islower(input[i]))
        {
            printf("%c", (input[i] - 96 + move) % 26 + 96);
        }
        
        // if the letter is uppercase, the program will find the corresponding
        // uppercase letter (loops between 65 and 90)
        else if (isupper(input[i]))
        {
            printf("%c", (input[i] - 64 + move) % 26 + 64);
        }
        
        // if the character is not a letter, it simply prints it out unchanged
        // and increase "counter" by 1
        else
        {
            printf("%c", input[i]);
            counter++;
        }
    }
    printf("\n");
}