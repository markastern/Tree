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
