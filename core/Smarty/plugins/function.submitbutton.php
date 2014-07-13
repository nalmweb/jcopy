<?
    function smarty_function_submitbutton($params, &$smarty)
    {
        $params['name']     = ( !isset($params['name']) ) ? "ButtonSubmit" : $params['name'];
        $params['value']    = ( !isset($params['value']) ) ? null : $params['value'];

        $smarty->assign('params', $params);
        $_content = $smarty->fetch("_design/buttons/submit_button.tpl");
        return $_content;
    }
?>