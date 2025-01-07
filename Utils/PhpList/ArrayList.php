<?php
namespace AmsApp\Utils\PhpList;
class ArrayList implements PhpList
{
    private $list;

    public function __construct(array $initialList = [])
    {
        $this->list = array_values($initialList);
    }

    public function add($element): void
    {
        $this->list[] = $element;
    }

    public function addAt(int $index, $element): void
    {
        array_splice($this->list, $index, 0, [$element]);
    }

    public function get(int $index)
    {
        return $this->list[$index] ?? null;
    }

    public function getIndex($item): int {
        // Search for the item and return its index or -1 if not found
        $index = array_search($item, $this->list);
        return ($index === false) ? -1 : $index;
    }

    public function remove(int $index)
    {
        if (isset($this->list[$index])) {
            $value = $this->list[$index];
            array_splice($this->list, $index, 1);
            return $value;
        }
        return null;
    }

    public function contains($value): bool
    {
        return in_array($value, $this->list, true);
    }

    public function size(): int
    {
        return count($this->list);
    }

    public function clear(): void
    {
        $this->list = [];
    }

    public function isEmpty(): bool
    {
        return empty($this->list);
    }

    public function toArray(): array
    {
        return $this->list;
    }

    public function __toString(): string
    {
        return json_encode($this->list, JSON_PRETTY_PRINT);
    }

    public function echoList(): void
    {
        echo $this->__toString();
    }
}
