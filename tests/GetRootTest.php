<?php declare(strict_types=1);
include_once 'TestCase.php';

final class GetRootTest extends TestCase
{
    public function testCanGetRootFromTree(): void
    {
        $this->tree->init($this->data);
        $this->assertEquals(1, $this->tree->getRoot());
    }
}
