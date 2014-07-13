<?php

/**
 * Smarty form function 
 *
 * @param array $params
 * @param object $smarty
 * @return string
 */
function smarty_function_form_textarea($params, &$smarty)
{
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form_object = $smarty->_tpl_vars['wf_form_object'];    
    if (!isset($params['name'])) return 'Name for field not found.';
    //if (!$form_object->getElement($params['name'])))
    $value = (isset($params['value'])?$params['value']:'');
    unset($params['value']);
    $fields = '';
    foreach ($params as $k => &$v)
        $fields .= ' '.$k.'="'.$v.'"';
    $content = '<textarea'.$fields.'>'.$value.'</textarea>';
    return $content;
}