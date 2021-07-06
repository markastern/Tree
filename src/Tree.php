<?php

/*
Copyright 2021 Mark Stern

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Node
{
    public $parentId;
    public $children;
    public $value;
    public $verified;

    function __construct()
    {
        $this->parentId = NULL;
        $this->children = [];
        $this->value = NULL;
        $this->verified = FALSE;
    }

    public function addChild(int $id)
    {
        $this->children[] = $id;
    }
}


class Tree implements ITree
{
    protected $root = NULL;
    protected $nodes = [];

    /**
     * Initialize the tree from an array of nodes. Each node is an
     * array with the following keys:
     *
     * id - an integer identifier for the node
     * parent-id - the identifier of the parent node (NULL for the root node)
     * value - a String value of the node
     *
     * @param array $nodeData
     * @throws DoubleRootException
     * @throws DuplicateIDsException
     * @throws InvalidIDException
     * @throws InvalidParentIDException
     * @throws InvalidValueException
     * @throws MissingKeyException
     * @throws MissingRootException
     * @throws OrphanException
     */
    public function init(array $nodeData)
    {
        foreach ($nodeData as $node) {
            if (! is_array($node)) {
                throw new TypeError('Elements of initialization array must be arrays');
            }
            foreach (['id', 'parent_id', 'value'] as $key) {
                if (!array_key_exists($key, $node)) {
                    throw new MissingKeyException($key);
                }
            }
            $this->checkNodeValues($node);
            $id = $node['id'];
            $parentId = $node['parent_id'];
            $value = $node['value'];
            if (is_null($parentId)) {
                if (! is_null($this->root)) {
                    // The root has already been defined
                    throw new DoubleRootException();
                }
                $this->root = $id;
            } else {
                /* Add this node as a child to the parent. If the parent
                   has not been created yet, create it. */
                if (! array_key_exists($parentId, $this->nodes)) {
                    $this->nodes[$parentId] = new Node();
                }
                $this->nodes[$parentId]->addChild($id);
            }
            $this->populateNode($id, $parentId, $value);
        }
        if (is_null($this->root)) {
            throw new MissingRootException();
        }
        $this->checkAllNodesReachable();
    }

    /**
     * Returns the node id of the root node.
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Return the node id of the parent node of $node_id.
     * This will be null if $node_id is the root node.
     *
     * @param int $node_id
     * @return mixed
     * @throws MissingNodeException
     */
    public function getParent(int $node_id)
    {
        if (! array_key_exists($node_id, $this->nodes)) {
            throw new MissingNodeException($node_id);
        }
        return $this->nodes[$node_id]->parentId;
    }

    /**
     * Return an array of all the node ids of the children of $node_id.
     *
     * @param int $node_id
     * @return array
     * @throws MissingNodeException
     */
    public function getChildren(int $node_id): array
    {
        if (! array_key_exists($node_id, $this->nodes)) {
            throw new MissingNodeException($node_id);
        }
        return $this->nodes[$node_id]->children;
    }

    /**
     * Return the value stored at node $node_id.
     *
     * @param int $node_id
     * @return String
     * @throws MissingNodeException
     */
    public function getValue(int $node_id): String
    {
        if (! array_key_exists($node_id, $this->nodes)) {
            throw new MissingNodeException($node_id);
        }
        return $this->nodes[$node_id]->value;
    }

    /**
     * Check that all the nodes in the tree are actually reachable from the root node.
     * First mark all reachable nodes as verified, then look for ant that are not verified.
     *
     * @throws OrphanException
     */
    protected function checkAllNodesReachable(): void
    {
        $this->verifyNodes($this->root);
        foreach ($this->nodes as $id => $node) {
            if (! $node->verified) {
                throw new OrphanException($id);
            }
        }
    }

    /**
     * Recursively mark all nodes reachable from the specified node as verified.
     *
     * @param int $root
     */
    protected function verifyNodes(int $root)
    {
        $node = $this->nodes[$root];
        $node->verified = TRUE;
        foreach ($node->children as $child) {
            $this->verifyNodes($child);
        }
    }

    /**
     * Create a new node with the specified id, parent id and value.
     *
     * @param $id
     * @param $parentId
     * @param $value
     * @throws DuplicateIDsException
     */
    protected function populateNode($id, $parentId, $value): void
    {
        if (array_key_exists($id, $this->nodes)) {
            if (!is_null($this->nodes[$id]->value)) {
                throw new DuplicateIDsException($id);
            }
            // Already created when we created a child
            $nodeObject = $this->nodes[$id];
        } else {
            $nodeObject = new Node();
            $this->nodes[$id] = $nodeObject;
        }
        $nodeObject->parentId = $parentId;
        $nodeObject->value = $value;
    }

    /**
     * Checks the types of an individual node in the initialization array.
     *
     * @param array $node
     * @throws InvalidIDException
     * @throws InvalidParentIDException
     * @throws InvalidValueException
     */
    function checkNodeValues(array $node)
    {
        if (! is_int($node['id'])) {
            throw new InvalidIDException();
        }
        if (! (is_int($node['parent_id']) || is_null($node['parent_id']))) {
            throw new InvalidParentIDException();
        }
        if (! is_string($node['value'])) {
            throw new InvalidValueException();
        }
    }

    function __toString()
    {
        return print_r($this->nodes, true);
    }
}