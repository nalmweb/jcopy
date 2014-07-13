<?php
function smarty_block_contentblock($params, $content, &$smarty)
{
    if ( $content !== null ) {
        $params['width']        = ( !isset($params['width']) ) ? null : $params['width'];
        $params['height']       = ( !isset($params['height']) ) ? null : $params['height'];

        $smarty->assign("width", $params['width']);
        $smarty->assign("height", $params['height']);
        $smarty->assign("content", $content);
        $_content = $smarty->fetch("_design/content_blocks/content_block.tpl");

        return $_content;
    }
}

?>