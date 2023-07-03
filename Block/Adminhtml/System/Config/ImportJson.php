<?php

namespace Siteation\StoreInfoTokens\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ImportJson extends Field
{
    /**
     * Return the elements HTML value
     *
     * @param AbstractElement $element
     *
     * @return string
     * @throws NoSuchEntityException
     */

     /**
     * Return the elements HTML value
     *
     * @param AbstractElement $element
     *
     * @return string
     * @throws NoSuchEntityException
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $inputSrOnly = 'style="position:absolute;width:1px;height:1px;margin:-1px;white-space:nowrap;overflow:hidden;clip-path:inset(50%)"';

        $html =
        "<label class='action-default'>"
            . "<input type='file' id='siteation_tokens_file_upload' accept='.json' " . $inputSrOnly . ">"
        . "Import JSON</label>"
        . "<style>#siteation_storeinfo_tokens_tokens_tokens { min-height: 320px } #row_siteation_storeinfo_tokens_tokens_tokens_importer .use-default { display: none !important }</style>"
        . "<script>"
            . "const fileUpload = document.getElementById('siteation_tokens_file_upload');"
            . "const fileContent = document.getElementById('siteation_storeinfo_tokens_tokens_tokens');"
            . "const fileContentInherit = document.getElementById('siteation_storeinfo_tokens_tokens_tokens_inherit');"
            . "if (fileContent.disabled) { fileUpload.parentNode.classList.add('disabled') }"
            . "if (fileContentInherit ) { fileContentInherit.addEventListener('input', function (evt) {"
                . "fileUpload.parentNode.classList.toggle('disabled',evt.target.checked)"
            . "}) }"
            . "fileUpload.addEventListener('change', function () {"
                . "const file = fileUpload.files[0];"
                . "const reader = new FileReader();"
                . "reader.onload = function (e) {"
                    . "const content = e.target.result;"
                    . "fileContent.value = content;"
                . "};"
                . "reader.readAsText(file);"
                . "fileUpload.value = null;"
            . "});"
        . "</script>";

        return $html;
    }
}
