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

final class GetValueTest extends TestCase
{
    public function testCanGetValueFromTree(): void
    {
        $this->tree->init($this->data);
        $this->assertEquals('Sharon- child 2', $this->tree->getValue(3));
    }

    public function testCannotGetValueFromMissingNode(): void
    {
        $this->tree->init($this->data);
        $this->expectException(MissingNodeException::class);
        $this->tree->getValue(5);
    }

    public function testCannotGetValueFromInvalidNode(): void
    {
        $this->tree->init($this->data);
        $this->expectException(TypeError::class);
        $this->tree->getValue("fred");
    }

}
