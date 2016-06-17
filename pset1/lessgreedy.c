#include <stdio.h>
#include <cs50.h>
#include <math.h>

int main(void)
{
    float change;
    int cents;
    int coincoint = 0;
    do
    {
        printf("Hay! How much change is owed?\n");
        change = GetFloat();
    }
    while (change < 0);
    cents = (int)round(change * 100);
    if (cents >= 25)
    {
        do
        {
            cents = cents - 25;
            coincoint++;
        }
        while (cents >= 25);
    }
    if (cents >= 10)
    {
        do
        {
            cents = cents - 10;
            coincoint++;
        }
        while (cents >= 10);
    }
    if (cents >= 5)
    {
        do
        {
            cents = cents - 5;
            coincoint++;
        }
        while (cents >= 5);
    }
    if (cents >= 1)
    {
        do
        {
            cents = cents - 1;
            coincoint++;
        }
        while (cents >= 1);
    }
    printf("%i\n", coincoint);
}