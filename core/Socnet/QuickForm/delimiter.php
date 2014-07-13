<?php

require_once 'HTML/QuickForm/html.php';

class Socnet_QuickForm_delimiter extends HTML_QuickForm_html
{
    function Socnet_QuickForm_delimiter()
    {
        $this->HTML_QuickForm_html('{delimiter}');
        $this->_type = 'delimiter';
    }

    function accept(&$renderer)
    {
        $renderer->renderHtml($this);
    }


}
?>
