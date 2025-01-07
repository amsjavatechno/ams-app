<?php
namespace AmsApp\Utils\PhpList;
interface PhpList
{
    public function add($element): void;

    public function addAt(int $index, $element): void;

    public function get(int $index);

    public function getIndex($value);

    public function remove(int $index);

    public function contains($value): bool;

    public function size(): int;

    public function clear(): void;

    public function isEmpty(): bool;

    public function toArray(): array;

    public function __toString(): string;

    public function echoList() : void;
}
