<?php
include_once('ITree.php');

class MissingNodeException extends Exception
{
    public function __construct(int $node_id, Throwable $previous = NULL) {
        parent::__construct("Node $node_id does not exist in the tree.", 0, $previous);
    }
}

class Node
{
    public $parentId;
    public $children;
    public $value;

    function __construct()
    {
        $this->parentId = NULL;
        $this->children = [];
        $this->value = NULL;
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

    public function init(array $nodeData)
    {
        foreach ($nodeData as $node) {
            $id = $node['id'];
            $parentId = $node['parent_id'];
            $value = $node['value'];
            if (is_null($parentId)) {
                $this->root = $id;
            }
            if (array_key_exists($id, $this->nodes)) {
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