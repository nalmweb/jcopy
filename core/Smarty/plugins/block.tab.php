<?php
function smarty_block_tab($params, $content, &$smarty)
{
    if ( $content !== null ) {
        $content = '<ul class="tabs">'.$content.'</ul>';
        return $content;
    }
}

?>