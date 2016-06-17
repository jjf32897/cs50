#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <ctype.h>

int main(int argc, string argv[])
{
    // if 0 or multiple keys are entered, the program won't run
    if (argc != 2)
    {
        printf("You have to enter exactly one keyword.\n");
        return 1;
    }
    int move = atoi(argv[1]);
    
    // if the key entered is 26 or greater, it will simplify to a key 0 to 25
    if (move > 25)
    {
        move %= 26;
    }
    string input = GetString();
    int length;
    length = strlen(input);
    
    // operation will apply to each letter
    for (int i = 0; i < length; i++)
    {
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
        
        // if the character is not a letter, it will be printed out unchanged
        else
            printf("%c", input[i]);
    }
    printf("\n");
}