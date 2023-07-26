# Siteation - Magento 2 module Theme Tokens

[![Packagist Version](https://img.shields.io/packagist/v/siteation/magento2-module-theme-tokens?style=for-the-badge)](https://packagist.org/packages/siteation/magento2-module-theme-tokens)
![Supported Magento Versions](https://img.shields.io/badge/magento-%202.4-brightgreen.svg?logo=magento&longCache=true&style=for-the-badge)
[![Hyvä Themes Module](https://img.shields.io/badge/Hyva_Themes-Module-3df0af.svg?longCache=true&style=for-the-badge)](https://hyva.io/)
![License](https://img.shields.io/github/license/siteation/magento2-module-theme-tokens?color=%23234&style=for-the-badge)

This Magento 2 module makes it easy to manage Design Tokens from the Magento backend.

Once you have set your tokens,
they will be output as CSS variables to the frontend,
making it easy to style your website with consistent and reusable code.

## Installation

Install the package via;

```bash
composer require siteation/magento2-theme-tokens
bin/magento setup:upgrade
```

> **Note** This Module requires Magento 2.4 or higher and Hyvä Theme!
> For more requirements see the `composer.json`.

## How to use

Once the module is installed, you can manage your Design Tokens from the Magento backend.

1. Go to Stores > Configuration > Siteation > Design Tokens.
2. Enter your the tokens in the desired format.
4. Once you have set your tokens, they will be output as CSS variables to the frontend.
