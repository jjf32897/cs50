/**
 * dictionary.c
 *
 * Computer Science 50
 * Problem Set 5
 *
 * Implements a dictionary's functionality.
 */

#include <stdbool.h>
#include <cs50.h>
#include <stdio.h>
#include <string.h>
#include <ctype.h>
#include <stdint.h>

#include "dictionary.h"

#define HASH_SIZE 262144

// HASH_SIZE elements in the hash table were selected to yield a load factor < 1
// attempts to decrease collisions and increase speed
node* table[HASH_SIZE];
int wordCount = 0;

/**
 * Hash function.
 * Best Time: 4.680 s
 * Collisions: 32700 :(
 */
int hashDat(char word[])
{
    // djb2 hash function retrieved from the Department of Computer Science and
    // Engineering at York University
    unsigned long hash = 5381;
    int len = strlen(word);
    for (int i = 0; i < len; i++)
    {
        hash = ((hash << 5) + hash) + word[i];
    }
    
    // mod to place hash within boundaries of hash function
    return hash % HASH_SIZE;
}

/**
 * Returns true if word is in dictionary else false.
 */
bool check(const char* word)
{
    // makes a buffer and stores the word in it (including the '\0')
    char werd[LENGTH + 1];
    int len = strlen(word);
    for (int i = 0; i < len + 1; i++)
    {
        werd[i] = tolower(word[i]);
    }
    
    // hashes the word
    int index = hashDat(werd);
    
    // searches through the linked list of the corresponding bucket and checks
    // to see if the word is in any of the nodes
    node* cursor = table[index];
    while (cursor != NULL)
    {
        if (strcmp(werd, cursor->word) == 0)
        {
            return true;
        }
        cursor = cursor->next;
    }
    return false;
}

/**
 * Loads dictionary into memory.  Returns true if successful else false.
 */
bool load(const char* dictionary)
{
    // location of a word in the hash table
    int index;
    
    // opens the dictionary and checks if it opened successfully
    FILE* dict = fopen(dictionary, "r");
    if (dict == NULL)
    {
        printf("The dictionary could not be opened.\n");
        return 0;
    }
    
    // iterates through the dictionary one word at a time until EOF is reached
    while (!feof(dict))
    {
        // a new node is malloc'd and a word is fscanf'd into its word parameter
        node* new_node = malloc(sizeof(node));
        
        // checks for successful malloc; adds time, but is necessary
        if (new_node == NULL)
        {
            printf("Unsuccessful word load: memory allocation failed.\n");
            return 1;
        }
        
        fscanf(dict, "%s\n", new_node->word);
        
        // the word is hashed and its corresponding node is appended to the
        // beginning of the corresponding bucket's linked list
        index = hashDat(new_node->word);
        new_node->next = table[index];
        table[index] = new_node;
        
        // increase the wordCount by 1 for each word
        wordCount++;
    }
    
    // always free the memory allocated for a FILE*!
    fclose(dict);
    return true;
}

/**
 * Returns number of words in dictionary if loaded else 0 if not yet loaded.
 */
unsigned int size(void)
{
    // if words were actually loaded into the dictionary, return the number
    if (wordCount > 0)
    {
        return wordCount;
    }
    return 0;
}

/**
 * Unloads dictionary from memory.  Returns true if successful else false.
 */
bool unload(void)
{
    // iterates through each node* in the hash table
    for (int i = HASH_SIZE; i--; )
    {
        // sets the cursor to the beginning of the table
        node* cursor = table[i];
        
        // each node before the cursor is free'd while the cursor moves down the
        // list and keeps track of the rest of the list
        while (cursor != NULL)
        {
            node* temp = cursor;
            cursor = cursor->next;
            free(temp);
        }
    }
    return true;
}