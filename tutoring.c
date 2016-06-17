#include <stdio.h>
#include <stdlib.h>
#include <cs50.h>
#include <time.h>

int generateRoom(void);

int main(void)
{
    int matches = 0;
    for (int i = 0; i < 20; i++)
    {
        if (generateRoom() == 1)
        {
            matches++;
        }
    }
    printf("There were %d rooms that had matching birthdays.", matches);
}

int generateRoom(void)
{
    srand(time(NULL));
    int people[23];
    
    for (int i = 0; i < 23; i++)
    {
        int random;
        random = rand() % 366;
        printf("%d\n", random);
        for (int j = 0; j < i; j++)
        {
            if (random == people[j])
            {
                return 1;
            }
        }
        people[i] = random;
    }
    return 0;
}