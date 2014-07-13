<?php /* Smarty version 2.6.16, created on 2014-07-12 16:46:44
         compiled from admin/country.tpl */ ?>
<h1 class="orange">Управление странами</h1>
<p>Здесь вы можете добовлять или изменять страну</p>
<br/>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/errors.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

        <form <?php echo $this->_tpl_vars['formContent']['attributes']; ?>
>
          <table border=0 cellpadding=0 cellspacing=5>
            <tr>
              <td align="right" width="200"><?php echo $this->_tpl_vars['formContent']['country']['label']; ?>
</td>
              <td><?php echo $this->_tpl_vars['formContent']['country']['html']; ?>
</td>
            </tr>
            <tr>
              <td align="right"></td>
              <td><?php echo $this->_tpl_vars['formContent']['submitForm']['html']; ?>
</td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<br/>

<div class="black_box mTop10 radius">
  <div class="inner">
    <div id="ajaxContent" style="display:none"><?php echo $this->_tpl_vars['ajaxContent']; ?>
</div>
    <table class="sTable">
      <tr class="first">
        <td class="tleft">id</td>
        <td class="tleft">Навание</td>
        <td>Параметры</td>
      </tr>
    <?php $_from = $this->_tpl_vars['countries_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['name']):
?>
      <tr>
        <td width="40" class="tleft">
          <?php echo $this->_tpl_vars['id']; ?>

        </td>
        <td class="tleft">
          <?php echo $this->_tpl_vars['name']; ?>

        </td>

        <td width="40">

        </td>
      </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
  </div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "paginator.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>