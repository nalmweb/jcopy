<?php

require_once 'HTML/QuickForm/Page.php';
require_once 'HTML/QuickForm/Controller.php';


class Socnet_QuickForm_Controller extends HTML_QuickForm_Controller
{
    function Socnet_QuickForm_Controller($name, $modal = true)
    {
        $this->_name  = $name;
        $this->_modal = $modal;
    }

    function &container($reset = false)
    {
        //$session = Zend::registry("SESSION");
        $name = '_' . $this->_name . '_container';
        if (!isset($_SESSION[$name]) || $reset) {
            $_SESSION[$name] = array(
                'defaults'  => array(),
                'constants' => array(),
                'values'    => array(),
                'valid'     => array()
            );
        }
        foreach (array_keys($this->_pages) as $pageName) {
            if (!isset($_SESSION[$name]['values'][$pageName])) {
                $_SESSION[$name]['values'][$pageName] = array();
                $_SESSION[$name]['valid'][$pageName]  = null;
            }
        }
        return $_SESSION[$name];
    }
}
?>
