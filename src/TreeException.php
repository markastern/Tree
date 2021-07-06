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
