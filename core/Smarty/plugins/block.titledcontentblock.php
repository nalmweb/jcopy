<?php
function smarty_block_titledcontentblock($params, $content, &$smarty)
{
    if ( $content !== null ) {
        $params['right_html']   = ( !isset($params['right_html']) ) ? "" : $params['right_html'];
        $params['title']        = ( !isset($params['title']) ) ? "" : $params['title'];
        $params['width']        = ( !isset($params['width']) ) ? null : $params['width'];
        $params['height']       = ( !isset($params['height']) ) ? null : $params['height'];
        $params['headerColor']     = ( !isset($params['headerColor']) ) ? 'blue' : $params['headerColor'];
        switch ($params['headerColor']) {
            case 'blue'     :       $params['color'] = '#3c4a7d';         break;
            case 'red'      :       $params['color'] = '#a03c30';         break;
            case 'green'    :       $params['color'] = '#597b40';         break;
            case 'transp'   :       $params['color'] = '#a03c30';         break;
            default         :       $params['color'] = '#3c4a7d'; $params['headerColor'] = "blue";
        }

        $smarty->assign("right_html", $params['right_html']);
        $smarty->assign("headerColor", $params['headerColor']);
        $smarty->assign("color", $params['color']);
        $smarty->assign("width", $params['width']);
        $smarty->assign("height", $params['height']);
        $smarty->assign("title", $params['title']);
        $smarty->assign("content", $content);
        $_content = $smarty->fetch("_design/content_blocks/titled_content_block.tpl");

        print $_content;
    }
}

?>