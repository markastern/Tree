<?php

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

    protected function verifyNodes(int $root)
    {
        $node = $this->nodes[$root];
        $node->verified = TRUE;
        foreach ($node->children as $child) {
            $this->verifyNodes($child);
        }
    }

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
            $id = $node['id'];
            $parentId = $node['parent_id'];
            $value = $node['value'];
            if (is_null($parentId)) {
                if (! is_null($this->root)) {
                    // The root has already been defined
                    throw new DoubleRootException();
                }
                $this->root = $id;
            }
            if (array_key_exists($id, $this->nodes)) {
                if (! is_null($this->nodes[$id]->value)) {
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

            if (! is_null($parentId)) {
                if (! array_key_exists($parentId, $this->nodes)) {
                    $this->nodes[$parentId] = new Node();
                }
                $this->nodes[$parentId]->addChild($id);
            }
        }
        if (is_null($this->root)) {
            throw new MissingRootException();
        }
        $this->checkAllNodesReachable();
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function getParent(int $node_id)
    {
        if (! array_key_exists($node_id, $this->nodes)) {
            throw new MissingNodeException($node_id);
        }
        return $this->nodes[$node_id]->parentId;
    }

    public function getChildren(int $node_id): array
    {
        if (! array_key_exists($node_id, $this->nodes)) {
            throw new MissingNodeException($node_id);
        }
        return $this->nodes[$node_id]->children;
    }

    public function getValue(int $node_id): String
    {
        if (! array_key_exists($node_id, $this->nodes)) {
            throw new MissingNodeException($node_id);
        }
        return $this->nodes[$node_id]->value;
    }

    public function checkAllNodesReachable(): void
    {
        $this->verifyNodes($this->root);
        foreach ($this->nodes as $id => $node) {
            if ($node->verified === FALSE) {
                throw new OrphanException($id);
            }
        }
    }

}