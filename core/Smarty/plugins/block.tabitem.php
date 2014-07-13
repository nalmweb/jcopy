<?php
function smarty_block_tabitem($params, $content, &$smarty)
{
    if ( $content !== null ) {
        $params['link'] = ( !isset($params['link']) ) ? '#' : $params['link'];
        $onclick = ( isset($params['onclick']) ) ? sprintf(" onclick=\"%s\"",$params['onclick']) : "";
        
        if ( isset($params['active']) && $params['active'] ) {
            $content = '<li class="active"><a href="'.$params['link'].'" class="active"'. $onclick .'>'.$content.'</a></li>';
        } else {
            $content = '<li><a href="'.$params['link'].'"'. $onclick .'>'.$content.'</a></li>';
        }
        return $content;
    }
}

?>