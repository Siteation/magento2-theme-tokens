<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\ThemeTokens\Model\Parser;

use Siteation\ThemeTokens\Model\ObjectHelper;

class DesignSystem
{
    protected ObjectHelper $objectHelper;

    public function __construct(ObjectHelper $objectHelper)
    {
        $this->objectHelper = $objectHelper;
    }

    /**
     * Removes all deep nested keys except the key that you want to keep
     *
     * @param array $obj
     * @param string $keyToKeep - key to keep in the object
     * @return array - Same Object with only the selected key
     */
    private function removeAllExceptValue($obj, $keyToKeep = "value"): array
    {
        foreach ($obj as $key => $value) {
            if (is_array($value)) {
                $obj[$key] = $this->removeAllExceptValue($value, $keyToKeep);
            } elseif ($key !== $keyToKeep) {
                unset($obj[$key]);
            }
        }
        return $obj;
    }

    /**
     * Converts an Object of design tokens to a PHP based compatible tokens.
     *
     * This support the syntax used by figma and sketch,
     * not the W3C Community syntax (https://design-tokens.github.io/community-group/format/)
     *
     * @param array $tokens - Object of design tokens
     * @return array - Tailwind tokens
     */
    public function createTokens($tokens): array
    {
        if (!is_array($tokens) && $tokens !== null) {
            echo "This is not a valid tokens object";
            return [];
        }

        $tokens = $this->objectHelper->flattenObj($this->removeAllExceptValue($tokens));
        $newTokens = array();

        foreach ($tokens as $key => $value) {
            // First remove the "-value" from the key name
            // Second, make sure if the key has "default" that it is uppercase
            $newKey = str_replace("-value", "", $key);
            $tokens[$newKey] = $value;
            unset($tokens[$key]);

            // Revert the action from flattenObj
            $keys = explode("-", $newKey);
            $this->objectHelper->createObject($keys, $tokens[$newKey], $newTokens);
        }

        return $newTokens;
    }
}
