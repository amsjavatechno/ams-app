<?php
namespace AmsApp\Utils\PhpMap;
use AmsApp\Utils\PhpList\ArrayList;
use AmsApp\Utils\PhpList\PhpList;
class MapWrapper implements PhpMap{
    private $map;

    public function __construct(array $initialMap = []) {
        $this->map = $initialMap;
    }

    public function put($key, $value): void {
        $this->map[$key] = $value;
    }

    public function get($key) {
        return $this->map[$key] ?? null;
    }

    public function remove($key) {
        if (isset($this->map[$key])) {
            $value = $this->map[$key];
            unset($this->map[$key]);
            return $value;
        }
        return null;
    }

    public function containsKey($key): bool {
        return array_key_exists($key, $this->map);
    }

    public function containsValue($value): bool {
        return in_array($value, $this->map, true);
    }

    public function keySet(): PhpList {
        return new ArrayList(array_keys($this->map));
    }

    public function values(): PhpList {
        return new ArrayList(array_values($this->map));
    }

    public function size(): int {
        return count($this->map);
    }

    public function clear(): void {
        $this->map = [];
    }

    public function isEmpty(): bool {
        return empty($this->map);
    }

    public function putAll($other): void {
        if ($other instanceof self) {
            $other = $other->toArray();
        }
        $this->map = array_merge($this->map, $other);
    }

    public function entrySet(): PhpList {
        $entries = [];
        foreach ($this->map as $key => $value) {
            $entries[] = ['key' => $key, 'value' => $value];
        }
        return new ArrayList($entries);
    }

    public function toArray(): array {
        return $this->map;
    }

    public function __toString(): string {
        return json_encode($this->map, JSON_PRETTY_PRINT);
    }

    public function echoMap(): void
    {
        echo $this->__toString();
    }
}