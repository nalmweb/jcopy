<?php
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

class Socnet_QuickForm_Renderer_ArraySmarty extends HTML_QuickForm_Renderer_ArraySmarty
{
    function renderElement(&$element, $required, $error)
    {
        if ( $error != "" ) {
            $element->_attributes['style'] = (isset($element->_attributes['style'])) ? $element->_attributes['style'] : '';
            $element->_attributes['style'] .= ';border: 1px solid #FF0000;';
        }
        parent::renderElement($element, $required, $error);
    }
}

?>