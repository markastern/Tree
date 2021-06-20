<?php
interface ITree {
    Public function init(array $nodeData);
    public function getRoot();
    public function getParent(int $node_id);
    public function getChildren(int $node_id): array;
    public function getValue(int $node_id): string;
}
