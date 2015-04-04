<?php
/**
 * User: marcus
 * Date: 4/2/15
 * Time: 11:53 PM
 */

// Backend Form Fields
$GLOBALS['BE_FFL']['mibMultiLangText']     = 'MultiLangText';
$GLOBALS['BE_FFL']['mibMultiLangTextArea'] = 'MultiLangTextArea';

// Assets
if (TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = 'system/modules/mib-mulitlang-helper/assets/css/multilang.css';
    $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/mib-mulitlang-helper/assets/js/multilang.js';
}