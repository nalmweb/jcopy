<?php

require_once("HTML/QuickForm/input.php");

class Socnet_QuickForm_submit extends HTML_QuickForm_input
{
    private $color;

    function Socnet_QuickForm_submit($elementName=null, $value=null, $color = 'gray', $attributes=null)
    {
        HTML_QuickForm_input::HTML_QuickForm_input($elementName, null, $attributes);
        $this->setValue($value);
        $this->setType('submit');
        $this->color = $color;
        $this->color = ( !in_array($this->color, array('gray', 'green', 'orange', 'red')) ) ? 'gray' : $this->color;
    }

    function freeze()
    {
        return false;
    }

   /**
    * Only return the value if it is found within $submitValues (i.e. if
    * this particular submit button was clicked)
    */
    function exportValue(&$submitValues, $assoc = false)
    {
        return $this->_prepareValue($this->_findValue($submitValues), $assoc);
    }
    function toHtml()
    {
        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        } else {
            $smarty = new Smarty();
            $smarty->template_dir = DOC_ROOT.'/templates/';
            $smarty->compile_dir = DOC_ROOT.'/var/_compiled/site/';
            $smarty->assign("name", $this->getValue());
            $smarty->assign("color", $this->color);
            return $content = $this->_getTabs() . $smarty->fetch("_design/buttons/submit_button.tpl");
        }
    }
}
?>
