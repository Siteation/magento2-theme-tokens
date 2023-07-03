<?php

declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\StoreInfoTokens\Model;

class ObjectHelper
{
    /**
     * Turns a flat Object into a deep nested Object,
     * based on the keys
     *
     * @param array $keys - List of keys
     * @param mixed $value - value for the deepest key
     * @param array $obj - new deep nested object
     */
    public function createObject($keys, $value, &$obj)
    {
        $key = array_shift($keys);
        if (!array_key_exists($key, $obj)) {
            $obj[$key] = count($keys) > 0 ? array() : $value;
        }
        if (count($keys) > 0) {
            $this->createObject($keys, $value, $obj[$key]);
        }
    }

    /**
     * Flatten Object into a flat Object
     *
     * @param array $obj - object to flatten
     * @param string $separator - separator for flattened keys
     * @return array - flattened object
     */
    function flattenObj($obj, $separator = "-")
    {
        $result = array();

        foreach ($obj as $key => $value) {
            if (is_array($value)) {
                $temp = $this->flattenObj($value);
                foreach ($temp as $k => $v) {
                    $result[$key . $separator . $k] = $v;
                }
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
