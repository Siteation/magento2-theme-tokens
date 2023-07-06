<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\ThemeTokens\ViewModel;

use Siteation\ThemeTokens\Model\ObjectHelper;
use Siteation\ThemeTokens\Model\Parser\DesignSystem;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ThemeTokens implements ArgumentInterface
{
    protected ScopeConfigInterface $scopeConfig;
    protected ObjectHelper $objectHelper;
    protected DesignSystem $parserDesignSystem;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ObjectHelper $objectHelper,
        DesignSystem $parserDesignSystem
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->objectHelper = $objectHelper;
        $this->parserDesignSystem = $parserDesignSystem;
    }

    /**
     * Get store information
     *
     * @param string $attribute
     * @return mixed
     */
    public function getThemeTokensConfig(string $attribute)
    {
        $path = sprintf('siteation_themetokens/general/%s', $attribute);
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    public function getTokens(): string
    {
        return (string) $this->getThemeTokensConfig('tokens');
    }

    private function getTokensSyntax(): string
    {
        return (string) $this->getThemeTokensConfig('token_syntax');
    }

    /**
     * Convert a string to kebab case.
     *
     * @param string $string
     * @return string - kebab case string
     */
    private function kebabCase($string): string
    {
        return strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $string));
    }

    /**
     * Creates json object from a php array with CSS props.
     * This is used to create new php arrays.
     *
     * @param array $props
     * @return array
     */
    public function toStyleTokens($props): array
    {
        $styles = array();
        $stylesDark = array();

        foreach ($props as $name => $value) {
            if (is_string($value) || is_numeric($value)) {
            } elseif (is_array($value)) {
                $value = implode(',', $value);
            } else {
                echo "Value of $name is not a string or number.";
                continue;
            }

            $name = $this->kebabCase($name);

            if (substr($name, -8) === "-default") {
                $name = substr($name, 0, -8);
            }

            $varName = "--$name";
            if (strpos($name, "-@media:dark") !== false) {
                $varName = str_replace("-@media:dark", "", $varName);
            }

            if (strpos($name, "-@media:dark") !== false) {
                $stylesDark[$varName] = $value;
                continue;
            } else {
                $styles[$varName] = $value;
            }
        }

        return array(
            'styles' => $styles,
            'stylesDark' => $stylesDark,
        );
    }

    /**
     * Make sure this is valid JSON in a preformant way
     *
     * @param string $json
     * @return bool
     */
    private function validateJson($value): bool
    {
        if (is_array($value)) {
            return false;
        }

        if (!is_scalar($value) && !is_null($value) && !method_exists($value, '__toString')) {
            return false;
        }

        json_decode($value);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Flatten multiline string
     *
     * @param string $json
     * @return string
     */
    public function flattenString($string): string
    {
        $lines = explode(PHP_EOL, $string);
        $flatString = '';
        foreach ($lines as $line) {
            $trimmedLine = trim($line);
            if (!empty($trimmedLine)) {
                $flatString .= $trimmedLine;
            }
        }

        return $flatString;
    }

    /**
     * Convert JSON to CSS variables
     *
     * @param string $input JSON String
     * @param string $syntax options: raw, json, design_system
     * @return string
     */
    public function convertToCSSProps($input, $syntax = "json"): string
    {
        if (!$this->validateJson($input)) {
            return '';
        };

        $jsonTokens = json_decode($input, true);
        $tokens = $jsonTokens;

        if ($syntax === "design_system") {
            $tokens = $this->parserDesignSystem->createTokens($jsonTokens);
        }

        $flattenedTokens = $this->objectHelper->flattenObj($tokens);
        $styleTokens = $this->toStyleTokens($flattenedTokens);
        $styles = $styleTokens['styles'];

        $styleString = "";
        foreach ($styles as $name => $value) {
            $styleString .= "$name: $value;";
        }

        return $styleString;
    }

    /**
     * @return string
     */
    public function cssProps(): string
    {
        $tokens = $this->flattenString($this->getTokens());
        $syntax = $this->getTokensSyntax();

        if ($syntax !== "raw") {
            $tokens = $this->convertToCSSProps($tokens, $syntax);
        }

        if ($tokens) {
            return ":root {{$tokens}}";
        }

        return '';
    }
}
