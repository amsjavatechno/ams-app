<?php

namespace AmsApp\Utils\PhpMap;

use AmsApp\Utils\PhpList\PhpList;

interface PhpMap{
    public function put($key, $value): void;
    public function get($key);
    public function remove($key);
    public function containsKey($key): bool;
    public function containsValue($value): bool;
    public function keySet(): PhpList;
    public function values(): PhpList;
    public function size(): int;
    public function clear(): void;
    public function isEmpty(): bool;
    public function putAll($other): void;
    public function entrySet(): PhpList;
    public function toArray(): array;
    public function __toString(): string;
    public function echoMap():void;
}
