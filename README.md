# Tree
Tree is a class that models a hierarchy of data items (nodes) using a
parent/child relationship (tree).
Each data item can have only one parent, but a parent can have any number
of children. There can only be one root item.

## Initialization
The library should be initialized with an array of arrays, using the *init*
 method. Each of the latter represents a node. It must contain an id (integer),
a value (string) and a parent ID (integer). The parent id can be NULL to
indicate the root item.
Once initialized the data is read-only.

### Example
The following example creates a tree with 4 nodes. Node 1 is the parent node.

    $tree = new Tree();
    $tree->init([
        ['id' => 2, 'parent_id' => 1, 'value' => 'David- child 1'],
        ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
        ['id' => 3, 'parent_id' => 1, 'value' => 'Sharon- child 2'],
        ['id' => 4, 'parent_id' => 2, 'value' => 'grandchild']
    ]);

## Methods Available
*getRoot*
Returns the id of the root node of the tree.

*getValue*
Returns the value of the specified node.

*getChildren*
Returns an array of the ids of all the child nodes of the specified node.

By Mark Stern (markalexstern@gmail.com)
