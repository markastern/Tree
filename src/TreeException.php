<?php
class TreeException extends Exception {}

class MissingNodeException extends TreeException
{
    public function __construct(int $node_id, Throwable $previous = NULL)
    {
        parent::__construct("Node $node_id does not exist in the tree.", 0, $previous);
    }
}

class MissingKeyException extends TreeException
{
    public function __construct(String $key, Throwable $previous = NULL)
    {
        parent::__construct("An element of the initialization array is missing a required key: $key.", 0, $previous);
    }
}

class InvalidIDException extends TreeException
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("An element of the initialization array has an invalid id", 0, $previous);
    }
}

class InvalidParentIDException extends TreeException
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("An element of the initialization array has an invalid parent_id.", 0, $previous);
    }
}

class InvalidValueException extends TreeException
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("An element of the initialization array has an invalid value.", 0, $previous);
    }
}




class MissingRootException extends TreeException
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("The tree does not have a root.", 0, $previous);
    }
}

class DoubleRootException extends TreeException
{
    public function __construct(Throwable $previous = NULL)
    {
        parent::__construct("The tree has two roots (only one allowed).", 0, $previous);
    }
}

class DuplicateIDsException extends TreeException
{
    public function __construct(int $id, Throwable $previous = NULL)
    {
        parent::__construct("Initialization array has two elements with the same id: $id.", 0, $previous);
    }
}

class OrphanException extends TreeException
{
    public function __construct(int $id, Throwable $previous = NULL)
    {
        parent::__construct("Node with id $id is not reachable from the root of the tree.", 0, $previous);
    }
}