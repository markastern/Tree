<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class GetChildrenTest extends TestCase
{
    public function testCanGetChildrenFromTree(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2,    'value' => 'grandchild'],
        ];
        
        $tree = new Tree();
        $tree->init($data);
        $this->assertEquals([2, 3], $tree->getChildren(1));
    }
}
