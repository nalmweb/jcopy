<?php

/**
 * Smarty form function for element <input type=hidden>
 *
 * @param array $params
 * @param object $smarty
 * @return string
 */
function smarty_function_form_hidden($params, &$smarty)
{
    // form object verify
    $form = $smarty->_tpl_vars['wf_form_object'];

    // element name verify
    if (!isset($params['name'])) return 'Name for field not found.';

    // element default value
    if (isset($form->_defaults[$params['name']]))
        $params['value'] = $form->_defaults[$params['name']];
        
    $content = '<input type=hidden';
    foreach ($params as $k => &$v) $content .= ' '.$k.'="'.$v.'"';
    $content .= '>';
    
    return $content;
}