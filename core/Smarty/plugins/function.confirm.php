<?php
/**
 * Smarty plugin
 */


/**
 * Function {confirm}
 * Type: function
 * Name: confirm
 * Generates text link 
 *
 * @param text string - text string
*/
function smarty_function_confirm($params, &$smarty) {
    
    //dump($params);
    $text = (isset($params['question'])) ? $params['question'] : "Вы уверены?";
    
    
    return <<<TEXT
<a href="javascript:if (confirm('$text')) {document.location.href='$params[confirm_url]';}">$params[text]</a>
TEXT;
    
}
