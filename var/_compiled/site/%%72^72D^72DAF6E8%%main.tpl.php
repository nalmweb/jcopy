<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:39
         compiled from main.tpl */ ?>
<?php if ($this->_tpl_vars['invite'] == true): ?>
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['invite_template'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <body>
  <center>
    <div <?php echo $this->_tpl_vars['onload_attributes']; ?>
 <?php echo $this->_tpl_vars['body_attributes']; ?>
 style="width:900px; text-align: left">
  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['menu'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['loginContent'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  	<div class="content"> <pre> <?php echo $this->_tpl_vars['hot_actions']; ?>
 </pre>

  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['bodyContent'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div id="clear"></div>

  	<input type="hidden" name="ctrl" value="<?php echo $this->_tpl_vars['controller']; ?>
" id="ctrl">

    <div id="clear"></div>

    <input type="hidden" name="act"  value="<?php echo $this->_tpl_vars['action']; ?>
" id="act">

    <div id="clear"></div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
  </center>
  </body>
  </html>
<?php endif; ?>