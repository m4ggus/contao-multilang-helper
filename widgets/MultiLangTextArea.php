<?php
/**
 * User: marcus
 * Date: 4/3/15
 * Time: 8:40 PM
 */

namespace Mib\MultiLang;

/**
 * Class MultiLangTextArea
 * @package Mib\MultiLang
 */
class MultiLangTextArea extends MultiLangField
{
    /**
     * @var string The template file
     */
    protected $strTemplate = 'be_mib_multilangtextarea';


    private $intRows = 12;
    private $intCols = 80;

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

        if ($this->rte)
        {
            $this->strClass = trim($this->strClass . ' noresize');
        }

        $varCurrent = '';
        $script = '';

        foreach ($arrLanguages as $locale => $language) {

            $strClass = ($this->strClass != '') ? ' ' . $this->strClass : '';

            if ($locale == $strSelectedLocale) {
                $strClass .= ' active';
                $varCurrent = specialchars(@$varValue[$locale]);
            }

            $arrFields[] = sprintf('<textarea name="%s[%s]" id="ctrl_%s" class="tl_textarea%s" rows="%s" cols="%s"%s onfocus="Backend.getScrollOffset()">%s</textarea>%s',
                $this->strName,
                $locale,
                $this->strId.'_'.$locale,
                $strClass,
                $this->intRows,
                $this->intCols,
                $this->getAttributes(),
                specialchars(@$varValue[$locale]),
                $this->wizard
            );
        }


        $script = $this->rte ? "<script>MIB.MultiLang.init('ctrl_".$this->strId."', '".$strSelectedLocale."');</script>" : '';
        $varCurrent = !$this->rte ? array_shift($arrFields) : $varCurrent;

        $result = sprintf('<div class="mib-multi-lang">%s<div id="ctrl_%s"%s>%s</div>%s<div class="translations">%s</div>%s</div>',
            $this->generateLanguageSelection($arrLanguages, $strSelectedLocale),
            $this->strId,
            (($this->strClass != '') ? ' class="' . $this->strClass . ' control"' : ' class="control"'),
            $varCurrent,
            $this->wizard,
            implode(' ', $arrFields),
            $script
        );

        return $result;
    }
}