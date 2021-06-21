<?php declare(strict_types=1);
include_once 'TestCase.php';

final class GetParentTest extends TestCase
{
    public function testCanGetParentFromTree(): void
    {
        $this->tree->init($this->data);
        $this->assertEquals(2, $this->tree->getParent(4));
    }

    public function testCanGetParentFromRootNodeOfTree(): void
    {
        $this->tree->init($this->data);
        $this->assertNull($this->tree->getParent(1));
    }

    public function testCannotGetParentFromMissingNode(): void
    {
        $this->tree->init($this->data);
        $this->expectException(MissingNodeException::class);
        $this->tree->getParent(5);
    }

    public function testCannotGetParentFromInvalidNode(): void
    {
        $this->tree->init($this->data);
        $this->expectException(TypeError::class);
        $this->tree->getParent("fred");
    }
}
