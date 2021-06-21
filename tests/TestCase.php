<?php

class TestCase extends \PHPUnit\Framework\TestCase
{
    public $data;
    public $tree;

    protected function setUp(): void
    {
        // The data that will be used in all the tests (sometimes modified slightly).
        $this->data = [
            ['id' => 2, 'parent_id' => 1, 'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1, 'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2, 'value' => 'grandchild'],
        ];
        $this->tree = new Tree();
    }
}
