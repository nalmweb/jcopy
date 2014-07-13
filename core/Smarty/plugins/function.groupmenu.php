<?php
    function smarty_function_groupmenu($params, &$smarty)
    {
        $colors = array('blue'=>'#3C4C7C', 'red'=>'#A33C33', 'green'=>'#5C7C44', 'default'=>'#70A100');
        $tabs = array(
            'summary',
            'members',
            'messages',
            'photos',
            'lists',
            'events',
            'tags',
            'documents',
            'settings',
         );
        $params['active']       = ( !isset($params['active']) ) ? null : $params['active'];
        $params['color']        = ( !isset($params['color']) ) ? "default" : $params['color'];
        $params['color']        = ( !in_array($params['color'], array_keys($colors)) ) ? "default" : $params['color'];

        $smarty->assign("color", $params['color']);
        $smarty->assign("active", $params['active']);
        $_content = $smarty->fetch("_design/menu/group_menu.tpl");
        return $_content;
    }
?>