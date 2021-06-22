<?php declare(strict_types=1);
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