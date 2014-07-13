<?php

class Socnet_QuickForm_Renderer_Default extends HTML_QuickForm_Renderer_Default
{
    public $_Errors;

    public $_errorsTemplate =
        '<tr>
            <td style="white-space: nowrap; color: #CB0000;" align="left" valign="top" colspan="2">
                {errors}
            </td>
         </tr>';
    public $_delimiterTemplate =
        '<tr>
            <td style="white-space: nowrap;" align="left" valign="top" colspan="2">
                &nbsp;
            </td>
         </tr>';
    function Socnet_QuickForm_Renderer_Default ($template_name = null)
    {
        $this->_Errors = array();

        $this->HTML_QuickForm_Renderer_Default();

        if ( $template_name === null || !file_exists(DOC_ROOT.'/../templates/'.$template_name) ) {
            $template_name = '_design/quickform/renderer/default.tpl';
        }
        $smarty = new Smarty();
        $smarty->template_dir = DOC_ROOT.'/../templates/';
        $smarty->compile_dir = DOC_ROOT.'/../var/_compiled/site/';
        $smarty->fetch($template_name);
        if ( isset($smarty->_smarty_vars['capture']['FormTemplate']) ) {
            $this->setFormTemplate($smarty->_smarty_vars['capture']['FormTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['HeaderTemplate']) ) {
            $this->setHeaderTemplate($smarty->_smarty_vars['capture']['HeaderTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['ElementTemplate']) ) {
            $this->setElementTemplate($smarty->_smarty_vars['capture']['ElementTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['GroupElementTemplate']) ) {
            $this->setGroupElementTemplate($smarty->_smarty_vars['capture']['GroupElementTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['GroupTemplate']) ) {
            $this->setGroupTemplate($smarty->_smarty_vars['capture']['GroupTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['RequiredNoteTemplate']) ) {
            $this->setRequiredNoteTemplate($smarty->_smarty_vars['capture']['RequiredNoteTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['ErrorsTemplate']) ) {
            $this->setErrorsTemplate($smarty->_smarty_vars['capture']['ErrorsTemplate']);
        }
        if ( isset($smarty->_smarty_vars['capture']['DelimiterTemplate']) ) {
            $this->setDelimiterTemplate($smarty->_smarty_vars['capture']['DelimiterTemplate']);
        }
        unset($smarty);
    }
    /**
     * Устанавливает шаблон для элемента ErrorSummary
     *
     * @param string $html
     */
    function setErrorsTemplate($html)
    {
        $this->_errorsTemplate = $html;
    }
    /**
     * Устанавливает шаблон для элемента delimiter
     *
     * @param string $html
     */
    function setDelimiterTemplate($html)
    {
        $this->_delimiterTemplate = $html;
    }
    function renderElement(&$element, $required, $error)
    {
        if ( $error != "" ) {
            $element->_attributes['style'] = (isset($element->_attributes['style'])) ? $element->_attributes['style'] : '';
            $element->_attributes['style'] .= ';border: 1px solid #FF0000;';
        }
        //$element->setAttribute('id', $element->getAttribute('name'));
        if (!$this->_inGroup) {
            $html = $this->_prepareTemplate($element->getName(), $element->getLabel(), $required, $error);
            $this->_html .= str_replace('{element}', $element->toHtml(), $html);
            $this->_html = str_replace('{comment}', $element->getComment(), $this->_html);
        } elseif (!empty($this->_groupElementTemplate)) {
            $html = str_replace('{label}', $element->getLabel(), $this->_groupElementTemplate);
            $html = str_replace('{comment}', $element->getComment(), $html);
            if ($required) {
                $html = str_replace('<!-- BEGIN required -->', '', $html);
                $html = str_replace('<!-- END required -->', '', $html);
            } else {
                $html = preg_replace("/([ \t\n\r]*)?<!-- BEGIN required -->(\s|\S)*<!-- END required -->([ \t\n\r]*)?/iU", '', $html);
            }
            $this->_groupElements[] = str_replace('{element}', $element->toHtml(), $html);

        } else {
            $this->_groupElements[] = $element->toHtml();
        }
        if ( $error != "" ) {
            $this->_Errors[] = $error;
        }
    }

    function finishForm(&$form)
    {
        // add a required note, if one is needed
        if (!empty($form->_required) && !$form->_freezeAll) {
            $this->_html .= str_replace('{requiredNote}', $form->getRequiredNote(), $this->_requiredNoteTemplate);
        }
        // add form attributes and content
        $html = str_replace('{attributes}', $form->getAttributes(true), $this->_formTemplate);
        if (strpos($this->_formTemplate, '{hidden}')) {
            $html = str_replace('{hidden}', $this->_hiddenHtml, $html);
        } else {
            $this->_html .= $this->_hiddenHtml;
        }
        $this->_hiddenHtml = '';
        $this->_html = str_replace('{content}', $this->_html, $html);
        if ( sizeof($this->_Errors) != 0 ) {
            $this->_html = str_replace('{errors_summary}', $this->_errorsTemplate, $this->_html);
            $this->_html = str_replace('{errors}', join("<br>", $this->_Errors), $this->_html);
        } else {
            $this->_html = str_replace('{errors_summary}', '', $this->_html);
        }
        $this->_html = str_replace('{delimiter}', $this->_delimiterTemplate, $this->_html);


        // add a validation script
        if ('' != ($script = $form->getValidationScript())) {
            $this->_html = $script . "\n" . $this->_html;
        }
    }
}

?>