<?php
include_once('ITree.php');

class MissingNodeException extends Exception
{
    public function __construct(int $node_id, Throwable $previous = NULL)
    {
        parent::__construct("Node $node_id does not exist in the tree.", 0, $previous);
    }
}

class MissingKeyException extends Exception
{
    public function __construct(String $key, Throwable $previous = NULL)
    {
        parent::__construct("An element of the initialization array is missing a required key: $key.", 0, $previous);
    }   
}

class MissingRootException extends Exception
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("The tree does not have a root.", 0, $previous);
    }
}

class DoubleRootException extends Exception
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("The tree has two roots (only one allowed).", 0, $previous);
    }
}

class DuplicateIDsException extends Exception
{
    public function __construct(int $id, Throwable $previous = NULL)
    {
        parent::__construct("Initialization array has two elements with the same id: $id.", 0, $previous);
    }
}

class OrphanException extends Exception
{
    public function __construct(int $id, Throwable $previous = NULL)
    {
        parent::__construct("Node with id $id is not reachable from the root of the tree.", 0, $previous);
    }    
}

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
        $this->verifyNodes($this->root);
        foreach ($this->nodes as $id => $node) {
            if ($node->verified === FALSE) {
                throw new OrphanException($id);
            }
        }
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

}