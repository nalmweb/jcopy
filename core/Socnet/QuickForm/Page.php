<?php
require_once 'HTML/QuickForm.php';

class Socnet_QuickForm_Page extends HTML_QuickForm{

    function Socnet_QuickForm_Page($formName, $method = 'post', $action = '', $trackSubmit = true,  $target = '', $attributes = null){
        $this->HTML_QuickForm($formName, $method, $action, $target, $attributes,$trackSubmit);
    }
    /**
     * Enter description here...
     *
     * @param array $elements
     */
    function addElements($elements){
        foreach ($elements as $item) {
            $this->addElement($item);
        }
    }

}
?>