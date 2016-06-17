#include <stdio.h>
#include <cs50.h>
#include <ctype.h>

int board[2][2] = {{1,2},{3,4}};
int t1;
int t2;
void findTile(int v);

int main(int argc, int argv[])
{
    int k = atoi(argv[1]);
    findTile(2);
    board[t1][t2] = 0;
    findTile();
    board[t1][t2] = 0;
    for (int j = 0; j < 2; j++)
    {
        for (int q = 0; q < 2; q++)
        {
            printf(" %i ", board[j][q]);
        }
        printf("\n");
    }
}
void findTile(int v)
{
    for (int m = 0; m < 2; m++)
    {
        for (int s = 0; s < 2; s++)
        {
            if(board[m][s] == v)
            {
                t1 = m;
                t2 = s;
                break;
            }
        }
    }
}