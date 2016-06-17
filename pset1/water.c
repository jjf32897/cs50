#include <stdio.h>
#include <cs50.h>

int main(void)
{
    int m;
    do
    {
        printf("minutes: ");
        m = GetInt();
    }
    while (m <= 0);
    
    //conversion from minutes to bottles is described by the simplified formula m * 12
    printf("bottles: %i\n", m * 12);
}