<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\ThemeTokens\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

class ParserOptions implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        $options = [
            "raw" => "CSS Variables",
            "json" => "JSON Tokens",
            "design_system" => "Design System Tokens"
        ];

        return $options;
    }
}
