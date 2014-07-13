<?
    function smarty_function_linkbutton($params, &$smarty)
    {
        $params['name']     = ( !isset($params['name']) ) ? "ButtonLink" : $params['name'];
        $params['link']     = ( !isset($params['link']) ) ? "#null" : $params['link'];
        $params['onclick']  = ( !isset($params['onclick'] ) ) ? null : $params['onclick'];
        $params['id'] = ( !isset($params['id'] ) ) ? null : $params['id'];

        $smarty->assign('params', $params);
        $_content = $smarty->fetch("_design/buttons/link_button.tpl");
        return $_content;
    }
?>