<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:45
         compiled from _design/buttons/submit_button.tpl */ ?>
<?php echo '<div><input class="button" type="submit"  ';  $_from = $this->_tpl_vars['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
 echo ' ';  echo $this->_tpl_vars['key'];  echo '="';  echo $this->_tpl_vars['value'];  echo '"';  endforeach; endif; unset($_from);  echo '/></div>'; ?>