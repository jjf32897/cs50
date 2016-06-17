/**
 * fifteen.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Implements Game of Fifteen (generalized to d x d).
 *
 * Usage: fifteen d
 *
 * whereby the board's dimensions are to be d x d,
 * where d must be in [DIM_MIN,DIM_MAX]
 *
 * Note that usleep is obsolete, but it offers more granularity than
 * sleep and is simpler to use than nanosleep; `man usleep` for more.
 */
 
#define _XOPEN_SOURCE 500

#include <cs50.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

// constants
#define DIM_MIN 3
#define DIM_MAX 9

// board
int board[DIM_MAX][DIM_MAX];

// dimensions
int d;

// prototypes
void clear(void);
void greet(void);
void init(void);
void draw(void);
bool move(int tile);
bool won(void);
bool swap(int newBlankX, int newBlankY, int newTileX, int newTileY, int daTile);

int main(int argc, string argv[])
{
    // ensure proper usage
    if (argc != 2)
    {
        printf("Usage: fifteen d\n");
        return 1;
    }

    // ensure valid dimensions
    d = atoi(argv[1]);
    
    if (d < DIM_MIN || d > DIM_MAX)
    {
        printf("Board must be between %i x %i and %i x %i, inclusive.\n",
            DIM_MIN, DIM_MIN, DIM_MAX, DIM_MAX);
        return 2;
    }

    // open log
    FILE* file = fopen("log.txt", "w");
    if (file == NULL)
    {
        return 3;
    }

    // greet user with instructions
    greet();

    // initialize the board
    init();

    // accept moves until game is won
    while (true)
    {
        // clear the screen
        clear();

        // draw the current state of the board
        draw();

        // log the current state of the board (for testing)
        for (int i = 0; i < d; i++)
        {
            for (int j = 0; j < d; j++)
            {
                fprintf(file, "%i", board[i][j]);
                if (j < d - 1)
                {
                    fprintf(file, "|");
                }
            }
            fprintf(file, "\n");
        }
        fflush(file);

        // check for win
        if (won())
        {
            printf("ftw!\n");
            break;
        }

        // prompt for move
        printf("Tile to move: ");
        int tile = GetInt();
        
        // quit if user inputs 0 (for testing)
        if (tile == 0)
        {
            break;
        }

        // log move (for testing)
        fprintf(file, "%i\n", tile);
        fflush(file);

        // move if possible, else report illegality
        if (!move(tile))
        {
            printf("\nIllegal move.\n");
            usleep(400000);
        }

        // sleep thread for animation's sake
        usleep(100000);
    }
    
    // close log
    fclose(file);

    // success
    return 0;
}

/**
 * Clears screen using ANSI escape sequences.
 */
void clear(void)
{
    printf("\033[2J");
    printf("\033[%d;%dH", 0, 0);
}

/**
 * Greets player.
 */
void greet(void)
{
    clear();
    printf("WELCOME TO GAME OF FIFTEEN\n");
    usleep(2000000);
}

/**
 * Initializes the game's board with tiles numbered 1 through d * d - 1
 * Fills 2D array with values but does not actually print them
 */
void init(void)
{
    int tileNum = d * d - 1;
    
    // iterates through array, left to right, top to bottom, filling board with
    // numbers in descending order starting with d * d - 1
    for (int i = 0; i < d; i++)
    {
        for (int j = 0; j < d; j++, tileNum--)
        {
            board[i][j] = tileNum;
        }
    }
    
    // will switch the 1 and 2 tiles if the board has an even dimension
    if (d % 2 == 0)
    {
        board[d - 1][d - 3] = 1;
        board[d - 1][d - 2] = 2;
    }
}

/**
 * Prints the board in its current state.
 */
void draw(void)
{
    for (int k = 0; k < d; k++)
    {
        for (int l = 0; l < d; l++)
        {
            // if it is the blank tile (value of 0), it will display as a " _ "
            if (board[k][l] == 0)
            {
                printf(" _ ");
            }
            
            // aligns single digit numbers appropriately
            else if (board[k][l] % 10 == board[k][l])
            {
                printf(" %i ", board[k][l]);
            }
            else
            {
                printf("%i ", board[k][l]);
            }
        }
        printf("\n");
    }
    printf("\n");
}

/**
 * If tile borders empty space, moves tile and returns true, else
 * returns false. 
 * Looks through array for blank (0) space. When found, will check to see if
 * it borders the empty tile. If so, it uses swap to switch them and return true
 */
bool move(int tile)
{
    for (int m = 0; m < d; m++)
    {
        for (int n = 0; n < d; n++)
        {
            if (board[m][n] == 0)
            {
                if (board[m + 1][n] == tile)
                {
                    return swap(m + 1, n, m, n, tile);
                }
                else if (board[m - 1][n] == tile)
                {
                    return swap(m - 1, n, m, n, tile);
                }
                else if (board[m][n + 1] == tile)
                {
                    return swap(m, n + 1, m, n, tile);
                }
                else if (board[m][n - 1] == tile)
                {
                    return swap(m, n - 1, m, n, tile);
                }
            }
        }
    }
    return false;
}

/**
 * Returns true if game is won (i.e., board is in winning configuration), 
 * else false.
 */
bool won(void)
{
    // if the blank tile is not in the bottom right, the game is incomplete
    if (board[d - 1][d - 1] != 0)
    {
        return false;
    }
    
    // iterates through the if the board; if the next tile in the row or column 
    // is lower in value, the board is obviously incomplete
    for (int o = 0; o < d - 1; o++)
    {
        for (int p = 0; p < d - 1; p++)
        {
            if (board[o][p] > board[o][p + 1] || board[o][p] > board[o + 1][p])
            {
                return false;
            }
        }
    }
    return true;
}

/**
 * Swaps inputted tile with blank tile and returns true
 */
bool swap(int newBlankX, int newBlankY, int newTileX, int newTileY, int daTile)
{
    board[newBlankX][newBlankY] = 0;
    board[newTileX][newTileY] = daTile;
    return true;
}