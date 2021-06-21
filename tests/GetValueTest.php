<?php declare(strict_types=1);
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
