<?php
/**
 * User: marcus
 * Date: 4/3/15
 * Time: 12:01 AM
 */

namespace Mib\MultiLang;

/**
 * Class MultiLangText
 * @package Mib\MultiLang
 */
class MultiLangText extends MultiLangField
{
    /**
     * @var string The template file
     */
    protected $strTemplate = 'be_mib_multilangtext';

    /**
     * Generate the widget and return it as string
     *
     * @return string The widget markup
     */
    public function generate()
    {
        $arrLanguages = $this->getUsedLanguages();
        $arrFields = [];

        $varValue = $this->varValue;


        if (!is_array($varValue)) {

            $arrLocales = array_keys($arrLanguages);

            $varValue = [reset($arrLocales) => $this->varValue];
        }


//        $strSelectedLocale = $GLOBALS['TL_LANGUAGE'];
//        if (!isset($varValue[$strSelectedLocale])) {
            $arrLocales = array_keys($varValue);
            $strSelectedLocale = reset($arrLocales);
//        }

        foreach ($arrLanguages as $locale => $language) {

            $arrFields[] = sprintf(
                '<input type="%s" name="%s[%s]" id="ctrl_%s" class="tl_text%s" value="%s"%s onfocus="Backend.getScrollOffset()">',
                'text',
                $this->strName,
                $locale,
                $this->strId.'_'.$locale,
                $strSelectedLocale == $locale ? ' active' : '',
                specialchars(@$varValue[$locale]), // see #4979
                $this->getAttributes()
            );
        }

        $arrCurrent = array_shift($arrFields);

        $result = sprintf('<div class="mib-multi-lang">%s<div id="ctrl_%s"%s>%s</div>%s<div class="translations">%s</div></div>',
            $this->generateLanguageSelection($arrLanguages, $strSelectedLocale),
            $this->strId,
            (($this->strClass != '') ? ' class="' . $this->strClass . ' control"' : ' class="control"'),
            $arrCurrent,
            $this->wizard,
            implode(' ', $arrFields)
        );

        return $result;
    }
}