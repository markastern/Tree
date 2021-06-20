<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class InitTest extends TestCase
{
    public function testCannotInitializeFromNonArray(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2,    'value' => 'grandchild'],
            "fred"
        ];
        
        $tree = new Tree();
        $this->expectException(TypeError::class);
        $tree->init($data);
    }

    public function testMissingId(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            [           'parent_id' => 2,    'value' => 'grandchild'],
        ];
        
        $tree = new Tree();
        $this->expectException(MissingKeyException::class);
        $tree->init($data);
    }

    public function testMissingParentId(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4,                      'value' => 'grandchild'],
        ];
        
        $tree = new Tree();
        $this->expectException(MissingKeyException::class);
        $tree->init($data);
    }

    public function testMissingValue(): void
    {
        $data = [
            ['id' => 2, 'parent_id' => 1,    'value' => 'David- child 1'],
            ['id' => 1, 'parent_id' => null, 'value' => 'Grandfather- root'],
            ['id' => 3, 'parent_id' => 1,    'value' => 'Sharon- child 2'],
            ['id' => 4, 'parent_id' => 2],
        ];
        
        $tree = new Tree();
        $this->expectException(MissingKeyException::class);
        $tree->init($data);
    }
}