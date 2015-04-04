<?php
/**
 * User: marcus
 * Date: 4/3/15
 * Time: 12:10 AM
 */

namespace Mib\MultiLang;

use Contao\Database;
use Contao\Widget;

/**
 * Class MultiLangField
 * @package Mib\MultiLang
 */
abstract class MultiLangField extends Widget
{
    /**
     * Submit indicator
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Language array used as root page language
     * @var array
     */
    private $arrUsedLanguages;

    /**
     * Mapping array for the flags
     * @var array
     */
    protected static $arrLocale2FlagMap = [
        MultiLang::DEFAULT_LOCALE => 'europeanunion',
        'en' => 'gb',
    ];

    /**
     * Parses the template
     * Generates the widget and returns the parsed template file
     * @param null $arrAttributes
     * @return string
     */
    public function parse($arrAttributes = null)
    {
        $this->_initUsedLanguages();

        return parent::parse($arrAttributes);
    }

    /**
     * @return mixed
     */
    public function getUsedLanguages()
    {
        return $this->arrUsedLanguages;
    }

    /**
     *
     */
    private function _initUsedLanguages()
    {
        $objDatabase = Database::getInstance();

        $arrSystemLanguages = self::getLanguages(true);

        $strQuery = "SELECT `language` FROM `tl_page` WHERE `language` != '' GROUP BY `language`";
        $arrPageLanguages   = $objDatabase
            ->prepare($strQuery)
            ->execute()->fetchEach('language');

        $arrIntersectLanguages = array_intersect(array_keys($arrSystemLanguages), $arrPageLanguages);

        $arrUsedLanguages = array_intersect_key($arrSystemLanguages, array_flip($arrIntersectLanguages));

        $arrUsedLanguages = [MultiLang::DEFAULT_LOCALE => 'MultiLingual'] + $arrUsedLanguages;

        $this->arrUsedLanguages = $arrUsedLanguages;
    }

    /**
     * @param array $arrLanguages
     * @param string $active
     * @return string
     */
    public function generateLanguageSelection(array &$arrLanguages, $active = '')
    {
        $arrOptions   = [];

        foreach ($arrLanguages as $locale => $language)
        {
            $filename = $this->mapLocaleToFlagFilename($locale);

            $arrOptions[] = sprintf(
                '<span class="locale%s" onclick="MIB.MultiLang.switchLocale(this);" data-locale="%s"><img src="%s" alt="%s" title="%s" /></span>',
                $locale == $active ? ' active' : '',
                $locale,
                $filename,
                $language,
                $language
            );
        }

        $result = sprintf(
            '<div class="locales">%s</div>',
            implode('', $arrOptions)
        );

        return $result;
    }

    /**
     * @param $locale
     * @return string
     */
    protected function mapLocaleToFlagFilename($locale)
    {
        $flag = str_replace(
            array_keys(static::$arrLocale2FlagMap),
            static::$arrLocale2FlagMap,
            $locale
        );

        $filename = sprintf(
            'system/modules/mib-mulitlang-helper/assets/img/%s.png',
            $flag
        );

        return $filename;
    }


    /**
     * Recursively validate an input variable
     * @param mixed $varInput The user input
     * @return mixed The original or modified user input
     */
    protected function validator($varInput)
    {
        if (is_array($varInput)) {

            foreach ($varInput as $k=>$v)
            {
                if ($k == MultiLang::DEFAULT_LOCALE)
                    $varInput[$k] = $this->validator($v);
            }

            return $varInput;
        }

        return parent::validator($varInput);
    }


}