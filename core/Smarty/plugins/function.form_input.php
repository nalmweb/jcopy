<?php

/**
 * Smarty form function
 *
 * @param array $params
 * @param object $smarty
 * @return string
 */
function smarty_function_form_input($params, &$smarty)
{
    if (!isset($smarty->_tpl_vars['wf_form_object'])) return 'Form object not found.';
    $form_object = $smarty->_tpl_vars['wf_form_object'];
    if (!isset($params['name'])) return 'Name for field not found.';
    //if (!$form_object->getElement($params['name'])))
    $checked = '';
    $fields = '';
    if (isset($params['type']) && ($params['type'] == 'radio' || $params['type'] == 'checkbox'))
    {
        if ($params['value'] == $params['checked'])
            $checked = ' checked';
        unset($params['checked']);
    }
    foreach ($params as $k => &$v)
        $fields .= ' '.$k.'="'.$v.'"';
    $content = '<input'.$fields.$checked.'>';
    return $content;
}