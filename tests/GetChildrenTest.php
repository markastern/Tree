<?php declare(strict_types=1);
include_once('TestCase.php');

final class GetChildrenTest extends TestCase
{
    public function testCanGetChildrenFromTree(): void
    {
        $this->tree->init($this->data);
        $children = $this->tree->getChildren(1);
        sort($children);
        $this->assertEquals([2, 3], $children);
    }

    public function testCannotGetChildrenFromMissingNode(): void
    {
        $this->tree->init($this->data);
        $this->expectException(MissingNodeException::class);
        $this->tree->getChildren(5);
    }

    public function testCannotGetChildrenFromInvalidNode(): void
    {
        $this->tree->init($this->data);
        $this->expectException(TypeError::class);
        $this->tree->getChildren("fred");
    }
}
