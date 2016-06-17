/**
 * generate.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Generates pseudorandom numbers in [0,LIMIT), one per line.
 *
 * Usage: generate n [s]
 *
 * where n is number of pseudorandom numbers to print
 * and s is an optional seed
 */
 
#define _XOPEN_SOURCE

#include <cs50.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

// constant
#define LIMIT 65536

int main(int argc, string argv[])
{
    float random; 
    // will not run if there is no input or more than two inputs
    if (argc != 2 && argc != 3)
    {
        printf("Usage: generate n [s]\n");
        return 1;
    }

    // converts the requested number of random #s into an int and stores it as n
    int n = atoi(argv[1]);

    // if a seed is given, it will establish the second input as the seed
    if (argc == 3)
    {
        srand48((long int) atoi(argv[2]));
    }
    else
    {
        srand48((long int) time(NULL));
    }

    // will generate n random integers between 0 and 6553
    for (int i = 0; i < n; i++)
    {
        random = drand48();
        printf("%i\n", (int) (drand48() * LIMIT));
    }

    // success
    return 0;
}