#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <ctype.h>

int main(void)
{
    string name = GetString();
    int length = strlen(name);
    
    // prints the first initial, capitalized
    printf("%c", toupper(name[0]));
    
    // since all spaces are followed by an initial, this loop goes through the
    // name and prints the capitalized letter following each space
    for (int i = 1; i < length; i++)
    {
        if (name[i] == 32)
        {
            printf("%c", toupper(name[i + 1]));
        }
    }
    printf("\n");
}