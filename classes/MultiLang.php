<?php
/**
 * User: marcus
 * Date: 4/3/15
 * Time: 8:13 PM
 */

namespace Mib\MultiLang;

/**
 * Class MultiLang
 * @package Mib\MultiLang
 */
class MultiLang {

    const DEFAULT_LOCALE = '_default_';

    /**
     * Translate a multi lang field by the given locale
     * If the locale is empty the current language settings
     * are used
     * @param $varValue
     * @param null $strLocale
     * @return array|mixed
     */
    public static function translate($varValue, $strLocale = null)
    {
        $strLocale = $strLocale ? : $GLOBALS['TL_LANGUAGE'];

        $varValue = deserialize($varValue);

        if (!is_array($varValue))
            return $varValue;

        return $varValue[$strLocale] ? : ($varValue[self::DEFAULT_LOCALE] ? : $varValue);
    }
}