<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class GetParentTest extends TestCase
{
    public function testCanGetParentFromTree(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2,    'value' => 'grandchild'],
        ];
        
        $tree = new Tree();
        $tree->init($data);
        $this->assertEquals(2, $tree->getParent(4));
    }

    public function testCannotGetParentFromMissingNode(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2,    'value' => 'grandchild'],
        ];
        
        $tree = new Tree();
        $tree->init($data);
        $this->expectException(MissingNodeException::class);
        $tree->getParent(5);
    }

    public function testCannotGetParentFromInvalidNode(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2,    'value' => 'grandchild'],
        ];
        
        $tree = new Tree();
        $tree->init($data);
        $this->expectException(TypeError::class);
        $tree->getParent("fred");
    }
}
