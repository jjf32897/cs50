#include <stdio.h>
#include <cs50.h>
#include <math.h>

int main(void)
{
    float change;
    int cents;
    int coincoint = 0;
    
    //declares an array with the 4 coin values
    int cointypes[4] = {25, 10, 5, 1};
    do
    {
        printf("Hello, how much change do I owe you?\n");
        change = GetFloat();
    }
    while (change < 0);
    
    //converts the decimal value to an integer (cents) and rounds to the nearest cent
    cents = (int)round(change * 100);
    
    //loops through the 4 coin values
    for (int i = 0; i < 4; i++)
    {
        //takes advantage of the fact that division of integers will automatically round down to an integer and adds as many whole quarters as possible to the coin coint
        coincoint += cents / cointypes[i];
        
        //finds how many cents will remain after removing as many coins 'i' as possible
        cents = cents % cointypes[i];
    }
    printf("%i\n", coincoint);
}