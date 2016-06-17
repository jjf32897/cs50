#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <ctype.h>

int main(int argc, string argv[])
{
    int values[argc - 1];
    int temp;
    int sorted;
    int counter = 0;
    for (int k = 1; k < argc; k++)
    {
        values[k - 1] = atoi(argv[k]);
    }
    do
    {
        sorted = 1;
        for (int i = 0; i < argc - 1 - counter; i++)
        {
            if (values[i] > values[i + 1])
            {
                temp = values[i];
                values[i] = values[i + 1];
                values[i + 1] = temp;
                sorted = 0;
            }
        }
        counter++;
    }
    while (sorted == 0);
    for (int j = 0; j < argc - 1; j++)
    {
        printf("%i\n", values[j]);
    }
}