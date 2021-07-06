<?php declare(strict_types=1);

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

include_once 'TestCase.php';

final class InitTest extends TestCase
{
    public function testCannotInitializeFromNonArray(): void
    {
        $this->data[] = "fred";
        $this->expectException(TypeError::class);
        $this->tree->init($this->data);
    }

    public function testMissingId(): void
    {
        unset($this->data[3]['id']);
        $this->expectException(MissingKeyException::class);
        $this->tree->init($this->data);
    }

    public function testMissingParentId(): void
    {
        unset($this->data[3]['parent_id']);
        $this->expectException(MissingKeyException::class);
        $this->tree->init($this->data);
    }

    public function testMissingValue(): void
    {
        unset($this->data[3]['value']);
        $this->expectException(MissingKeyException::class);
        $this->tree->init($this->data);
    }

    public function testInvalidId(): void
    {
        $this->data[3]['id'] = [3];
        $this->expectException(InvalidIDException::class);
        $this->tree->init($this->data);
    }

    public function testInvalidParentId(): void
    {
        $this->data[3]['parent_id'] = "dad";
        $this->expectException(InvalidParentIDException::class);
        $this->tree->init($this->data);
    }

    public function testInvalidValue(): void
    {
        $this->data[3]['value'] = 3;
        $this->expectException(InvalidValueException::class);
        $this->tree->init($this->data);
    }

    public function testMissingRoot(): void
    {
        $this->data = array_filter($this->data, function ($node) {
            return !is_null($node['parent_id']);
        });
        $this->expectException(MissingRootException::class);
        $this->tree->init($this->data);
    }

    public function testTwoRoots(): void
    {
        $this->data[3]['parent_id'] = null;
        $this->expectException(DoubleRootException::class);
        $this->tree->init($this->data);
    }

    public function testDuplicateIds(): void
    {
        $this->data[3]['id'] = $this->data[2]['id'];
        $this->expectException(DuplicateIdsException::class);
        $this->tree->init($this->data);
    }

    public function testOrphan(): void
    {
        $this->data[] = ['id' => 6, 'parent_id' => 5,    'value' => 'orphan'];
        $this->expectException(OrphanException::class);
        $this->tree->init($this->data);
    }

    public function testLoop(): void
    {
        $this->data[] = ['id' => 5, 'parent_id' => 6,    'value' => "I'm my own grandpa"];
        $this->data[] = ['id' => 6, 'parent_id' => 5,    'value' => 'father/son'];
        $this->expectException(OrphanException::class);
        $this->tree->init($this->data);
    } 
 }