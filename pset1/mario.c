#include <stdio.h>
#include <cs50.h>

int main(void)
{
    int h;
    do
    {
        printf("height: ");
        h = GetInt();
    }
    while (h < 0 || h > 23);
    if (h == 0)
        return 0;
        
    //loops for however many rows there are, starting at i = 1 to simplify expressions in embedded for loops
    for (int i = 1; i < h + 1; i++)
    {
        //prints h - i spaces on one line
        for (int a = 0; a < h - i; a++)
            printf(" ");
        
        //prints i #s right after the spaces on the same line
        for (int b = 0; b < i; b++)
            printf("#");
            
        //prints a # and goes to the next line since each row ends with an extra #
        printf("#\n");
    }
}