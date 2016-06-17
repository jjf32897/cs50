#include <stdio.h>
#include <stdlib.h>
#include <cs50.h>
#include <string.h>
#include <ctype.h>

int main(void)
{
    string s = GetString();
    printf("%i", s[0] + 40);
    printf("\n");
}