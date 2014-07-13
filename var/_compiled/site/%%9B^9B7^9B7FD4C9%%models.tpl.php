<?php /* Smarty version 2.6.16, created on 2014-07-12 17:41:02
         compiled from admin/catalog/models.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'admin/catalog/models.tpl', 12, false),array('function', 'form_select', 'admin/catalog/models.tpl', 15, false),array('function', 'form_hidden', 'admin/catalog/models.tpl', 21, false),array('function', 'form_text', 'admin/catalog/models.tpl', 24, false),array('function', 'form_checkbox', 'admin/catalog/models.tpl', 24, false),array('function', 'form_submit', 'admin/catalog/models.tpl', 29, false),)), $this); ?>

<h1 class="orange">Управление моделями производителей</h1>
<p>Здесь вы можете добовлять или изменять модели</p>
<br />

<div class="black_box mTop10 radius">
    <div class="inner">
        <div class="form">
            <div class="text">

                <div class='clear' style="padding:10px;">&#160;</div>
                <?php $this->_tag_stack[] = array('form', array('from' => $this->_tpl_vars['form'],'id' => 'change_models')); $_block_repeat=true;smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                  <fieldset>
                   <legend>Выбор производителя:</legend>
                     <label class="required">Марка (производитель):</label><?php echo smarty_function_form_select(array('name' => 'markId','id' => 'markId','selected' => $this->_tpl_vars['markId'],'options' => $this->_tpl_vars['marks'],'onChange' => "xajax_selectTrademark(this.options[this.selectedIndex].value); return false;",'style' => "width:200px;"), $this);?>
<br />
                 </fieldset>

                   <br>
                    <div id='models_block'>
                    <?php if ($this->_tpl_vars['markId']): ?>
                        <?php echo smarty_function_form_hidden(array('value' => $this->_tpl_vars['markId'],'name' => 'markId'), $this);?>

                        <?php if ($this->_tpl_vars['models']): ?>
                            <?php $_from = $this->_tpl_vars['models']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['model']):
?>
                                <?php echo smarty_function_form_text(array('name' => "models[".($this->_tpl_vars['model'])."->getId()]",'value' => $this->_tpl_vars['model']->getName()), $this); echo smarty_function_form_checkbox(array('checked' => $this->_tpl_vars['model']->getDisplay(),'name' => 'display'), $this);?>
<br />
                            <?php endforeach; endif; unset($_from); ?>
                        <?php endif; ?>
                        <?php echo smarty_function_form_text(array('name' => "models[new]"), $this);?>

                            <div class="clear" >&#160;</div>
                            <?php echo smarty_function_form_submit(array('name' => "Сохранить",'value' => "Сохранить"), $this);?>

                    <?php endif; ?>
                    </div>
                <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

            </div>
        </div>
    </div>
</div>