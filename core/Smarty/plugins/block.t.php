<?php
function smarty_block_t($params, $content, &$smarty)
{
    if ( $content !== null ) {
        //$params['width']        = ( !isset($params['width']) ) ? null : $params['width'];
        return $content;
    }
}

?>