<?php
/**
 * User: marcus
 * Date: 4/2/15
 * Time: 11:52 PM
 */

use Contao\ClassLoader;
use Contao\TemplateLoader;

ClassLoader::addNamespace('Mib\MultiLang');

ClassLoader::addClasses(
    [
        'Mib\MultiLang\MultiLang'
        => 'system/modules/mib-mulitlang-helper/classes/MultiLang.php',
        'Mib\MultiLang\MultiLangField'
        => 'system/modules/mib-mulitlang-helper/widgets/MultiLangField.php',
        'Mib\MultiLang\MultiLangText'
        => 'system/modules/mib-mulitlang-helper/widgets/MultiLangText.php',
        'Mib\MultiLang\MultiLangTextArea'
        => 'system/modules/mib-mulitlang-helper/widgets/MultiLangTextArea.php'
    ]
);

TemplateLoader::addFiles(
    [
        'be_mib_multilangtext' => 'system/modules/mib-mulitlang-helper/templates/widgets',
        'be_mib_multilangtextarea' => 'system/modules/mib-mulitlang-helper/templates/widgets',
    ]
);