<?php
namespace AmsApp\Utils;
use AmsApp\Utils\PhpList\ArrayList;
use AmsApp\Utils\PhpMap\MapWrapper;
use AmsApp\Utils\PhpList\PhpList;


class CollectionUtils {

    /**
     * Merge two PhpLists into a new ListWrapper.
     *
     * @param PhpList $list1
     * @param PhpList $list2
     * @return PhpList
     */
    public static function mergeLists(PhpList $list1, PhpList $list2): PhpList {
        $merged = array_merge($list1->toArray(), $list2->toArray());
        return new ArrayList($merged);
    }

    /**
     * Remove all elements in list2 from list1.
     *
     * @param PhpList $list1
     * @param PhpList $list2
     * @return PhpList
     */
    public static function subtractLists(PhpList $list1, PhpList $list2): PhpList {
        $filtered = array_filter($list1->toArray(), function($element) use ($list2) {
            return !$list2->contains($element);
        });
        return new ArrayList(array_values($filtered));
    }

    /**
     * Find common elements between two lists.
     *
     * @param PhpList $list1
     * @param PhpList $list2
     * @return PhpList
     */
    public static function intersectLists(PhpList $list1, PhpList $list2): PhpList {
        $intersection = array_intersect($list1->toArray(), $list2->toArray());
        return new ArrayList($intersection);
    }

    /**
     * Convert a PhpList to a PhpMap where the list elements are keys
     * and their values are set to a default value.
     *
     * @param PhpList $list
     * @param $defaultValue
     * @return PhpMap
     */
    public static function listToMap(PhpList $list, $defaultValue): PhpMap {
        $map = [];
        foreach ($list->toArray() as $key) {
            $map[$key] = $defaultValue;
        }
        return new MapWrapper($map);
    }

    /**
     * Merge two PhpMaps into a new MapWrapper.
     *
     * @param PhpMap $map1
     * @param PhpMap $map2
     * @return PhpMap
     */
    public static function mergeMaps(PhpMap $map1, PhpMap $map2): PhpMap {
        $merged = array_merge($map1->toArray(), $map2->toArray());
        return new MapWrapper($merged);
    }

    /**
     * Filter a map based on a condition applied to the values.
     *
     * @param PhpMap $map
     * @param callable $predicate
     * @return PhpMap
     */
    public static function filterMap(PhpMap $map, callable $predicate): PhpMap {
        $filteredMap = array_filter($map->toArray(), $predicate);
        return new MapWrapper($filteredMap);
    }

    /**
     * Get a PhpList of keys from a PhpMap where values satisfy a given condition.
     *
     * @param PhpMap $map
     * @param callable $predicate
     * @return PhpList
     */
    public static function filterMapKeys(PhpMap $map, callable $predicate): PhpList {
        $filteredKeys = [];
        foreach ($map->toArray() as $key => $value) {
            if ($predicate($value)) {
                $filteredKeys[] = $key;
            }
        }
        return new ArrayList($filteredKeys);
    }

    /**
     * Convert a PhpMap to a PhpList of key-value pairs.
     *
     * @param PhpMap $map
     * @return PhpList
     */
    public static function mapToList(PhpMap $map): PhpList {
        $entries = [];
        foreach ($map->toArray() as $key => $value) {
            $entries[] = ['key' => $key, 'value' => $value];
        }
        return new ArrayList($entries);
    }

    /**
     * Check if a PhpList is equal to another PhpList (same order, same elements).
     *
     * @param PhpList $list1
     * @param PhpList $list2
     * @return bool
     */
    public static function areListsEqual(PhpList $list1, PhpList $list2): bool {
        return $list1->toArray() === $list2->toArray();
    }

    /**
     * Converts an array to a ListWrapper (similar to Java's Arrays.asList()).
     *
     * @param array $array
     * @return ListInterface
     */
    public static function asList(array $array): PhpList {
        return new ArrayList($array);
    }

    /**
     * Check if two PhpMaps are equal (same keys and values).
     *
     * @param PhpMap $map1
     * @param PhpMap $map2
     * @return bool
     */
    public static function areMapsEqual(PhpMap $map1, PhpMap $map2): bool {
        return $map1->toArray() === $map2->toArray();
    }
}
