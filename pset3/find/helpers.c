/**
 * helpers.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Helper functions for Problem Set 3.
 */
       
#include <cs50.h>

#include "helpers.h"

/**
 * Returns true if value is in array of n values, else false.
 */
bool search(int value, int values[], int n)
{
    int first = 0;
    int last = n - 1;
    while (first <= last)
    {
        int center = (first + last) / 2;
        if (values[center] == value)
        {
            return true;
        }
        if (values[center] > value)
        {
            last = center - 1;
        }
        else
        {
            first = center + 1;
        }
    }
    return false;
}

/**
 * Sorts array of n values using bubble sort.
 */
void sort(int values[], int n)
{
    int temp;
    int sorted;
    int counter = 0;
    do
    {
        sorted = 1;
        for (int i = 0; i < n - 1 - counter; i++)
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
    return;
}