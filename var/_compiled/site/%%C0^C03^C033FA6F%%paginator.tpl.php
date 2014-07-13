<?php /* Smarty version 2.6.16, created on 2014-07-12 16:46:44
         compiled from paginator.tpl */ ?>
<?php if ($this->_tpl_vars['pgr'] && $this->_tpl_vars['pgr']['totalPages'] > 1): ?>
<div id="navigated">
  <ul>
    <?php $_from = $this->_tpl_vars['pgr']['urls']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['uri'] => $this->_tpl_vars['number']):
?>
      <?php if ($this->_tpl_vars['number'] == $this->_tpl_vars['pgr']['current']): ?>
        <li class="active"><?php echo $this->_tpl_vars['number']; ?>
</li>
      <?php else: ?>
        <li><a href="<?php echo $this->_tpl_vars['uri']; ?>
"><?php echo $this->_tpl_vars['number']; ?>
</a></li>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
  </ul>
</div>
<?php endif; ?>