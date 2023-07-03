<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2023 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\StoreInfoTokens\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

class ParserOptions implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        $options = [
            "json" => "JSON",
            "design_system" => "Design System (Figma, Sketch...)"
        ];

        return $options;
    }
}
