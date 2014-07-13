<?php /* Smarty version 2.6.16, created on 2014-07-13 16:41:00
         compiled from admin/catalog/changeTMLogo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'linkbutton', 'admin/catalog/changeTMLogo.tpl', 19, false),)), $this); ?>
<div id='msg'>
  <div id="window_title">Изменить логотоп для <strong><?php echo $this->_tpl_vars['tm']->getName(); ?>
</strong></div>
  <br>

  <div id="image"></div>
  <div style="margin: 0px 10px;">
    <div>
      <form method="POST" action="/admin/trademarks/" enctype="multipart/form-data">
        <input type="hidden" name="markId" value="<?php echo $this->_tpl_vars['tm']->getId(); ?>
">
        <input type="file" name="logo_<?php echo $this->_tpl_vars['tm']->getId(); ?>
"/>
        <br /><br />
        <center><input type="submit" name="submit" value="Загрузить"></center>
      </form>
    </div>
    <div id="divFileProgressContainer"></div>
    <div id="thumbnails"></div>
  </div>
  <center>
    <?php echo smarty_function_linkbutton(array('onclick' => "$.modal.close()",'name' => "Отмена"), $this);?>

  </center>
</div>
<div class="clear"></div>