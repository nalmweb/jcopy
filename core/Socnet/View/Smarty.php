<?php
/**
 *
 *
 * @copyright  Copyright (c) 2006
 */

require_once SMARTY_DIR . 'Smarty.class.php';

class Socnet_View_Smarty extends Zend_View_Abstract
{
    private $_smarty = false;
    public $layout = 'main.tpl';

    /**
     * Constructor
     *
     * @param array $data
     * @return void
     */
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->_smarty = new Smarty();
        $this->_smarty->debugging = true;
    }

    public function getSmarty()
    {
        return $this->_smarty;
    }

    /**
     * Assign new variable for smarty
     *
     * @param string|array $var - new variable name
     * @param mixed $value - new variable value
     * @return void
     */
    function assign($var, $value = null)
    {
        if (is_string($var)) {
            $this->_smarty->assign($var, $value);
        } elseif (is_array($var)) {
            foreach ($var as $key => $value) {
                $this->_smarty->assign($key, $value);
            }
        } else {
            throw new Zend_View_Exception('assign() expects a string or array, got ' . gettype($var));
        }

    }

    /**
     *  Escapes a value for output in a view script.
     *
     * @param mixed $var - string for escaping
     * @return mixed
     */
    public function escape($var)
    {
        if (is_string($var)) {
            return parent::escape($var);
        } elseif (is_array($var)) {
            foreach ($var as $key => $val) {
                $var[$key] = $this->escape($val);
            }
            return $var;
        } else {
            return $var;
        }
    }

    /**
     *  Processes a view and print the output.
     *
     * @param string $tpl_name - name of template
     * @return void
     */
    public function render($tpl_name)
    {
        $this->_smarty->display($tpl_name);
    }

    /**
     *  Processes a view and returns the output as string.
     *
     * @param string $tpl_name - name of template
     * @return string
     */
    public function getContents($tpl_name)
    {
        return ($this->_smarty->fetch($tpl_name));
    }

    /**
     *  Set dirictories for search templates
     *
     * @param string $dir
     * @return void
     */
    public function setTemplatesDir($dir)
    {
        $this->_smarty->template_dir = $dir;
    }

    /**
     *  Set debug
     *
     * @param boolian
     */
    public function setDebug($param)
    {
        $this->_smarty->debugging = $param;
    }

    /**
     * Set dirictories for search complited templates
     *
     * @param string $dir
     */
    public function setCompiledDir($dir)
    {
        $this->_smarty->compile_dir = $dir;
    }

    /**
     * Use to include the view script in a scope that only allows public
     * members.
     *
     * @return mixed
     */
    protected function _run()
    {
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}

?>