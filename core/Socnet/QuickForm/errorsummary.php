<?php

require_once 'HTML/QuickForm/html.php';

class Socnet_QuickForm_errorsummary extends HTML_QuickForm_html
{
    function Socnet_QuickForm_errorsummary()
    {
        $this->HTML_QuickForm_html('{errors_summary}');
        $this->_type = 'errorsummary';
    }
    function accept(&$renderer)
    {
        $renderer->renderHtml($this);
    }
}
?>
