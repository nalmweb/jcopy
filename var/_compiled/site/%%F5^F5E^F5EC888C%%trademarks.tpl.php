<?php /* Smarty version 2.6.16, created on 2014-07-13 16:40:54
         compiled from admin/catalog/trademarks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'form', 'admin/catalog/trademarks.tpl', 14, false),array('function', 'form_hidden', 'admin/catalog/trademarks.tpl', 28, false),array('function', 'form_text', 'admin/catalog/trademarks.tpl', 31, false),array('function', 'form_select', 'admin/catalog/trademarks.tpl', 34, false),array('function', 'form_submit', 'admin/catalog/trademarks.tpl', 46, false),array('modifier', 'cat', 'admin/catalog/trademarks.tpl', 28, false),)), $this); ?>
<h1 class="orange">Управление производителями</h1>
<p>Здесь вы можете добовлять или изменять производителей техники</p>
<br/>


<div class="black_box mTop10 radius">
    <div class="inner">


        <div>
            <div id="ajaxContent" style="display: none"><?php echo $this->_tpl_vars['ajaxContent']; ?>
<div class="clear"></div></div>

        </div>
    <?php $this->_tag_stack[] = array('form', array('from' => $this->_tpl_vars['form'])); $_block_repeat=true;smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

        <table class="sTable">
            <tr class="first">
                <td class="tleft">Лого</td>
                <td class="tleft">Название</td>
                <td class="tleft">Страна</td>
                <td>Операции</td>
            </tr>
            <?php $_from = $this->_tpl_vars['marks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['tm']):
?>
                <tr>
                    <td width="40" class="tleft">
                        <img src="<?php echo $this->_tpl_vars['tm']->getLogo()->getDataPath(); ?>
" title="<?php echo $this->_tpl_vars['tm']->getName(); ?>
" border="0"
                             style="max-width: 100px"/><br/>
                        <?php echo smarty_function_form_hidden(array('value' => $this->_tpl_vars['tm']->getLogo()->getId(),'name' => ((is_array($_tmp=((is_array($_tmp="trademarks[")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tm']->getId()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tm']->getId())))) ? $this->_run_mod_handler('cat', true, $_tmp, "][logo_id]") : smarty_modifier_cat($_tmp, "][logo_id]"))), $this);?>

                    </td>
                    <td class="tleft">
                        <?php echo smarty_function_form_text(array('value' => $this->_tpl_vars['tm']->getName(),'name' => ((is_array($_tmp=((is_array($_tmp="trademarks[")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tm']->getId()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tm']->getId())))) ? $this->_run_mod_handler('cat', true, $_tmp, "][name]") : smarty_modifier_cat($_tmp, "][name]")),'style' => "width: 150px;"), $this);?>

                    </td>
                    <td class="tleft">
                        <?php echo smarty_function_form_select(array('id' => 'country','selected' => $this->_tpl_vars['tm']->getIdCountry(),'options' => $this->_tpl_vars['countries'],'name' => ((is_array($_tmp=((is_array($_tmp="trademarks[")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tm']->getId()) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tm']->getId())))) ? $this->_run_mod_handler('cat', true, $_tmp, "][country_id]") : smarty_modifier_cat($_tmp, "][country_id]")),'style' => "width: 150px;"), $this);?>

                    </td>
                    <td width="40">
                        <div id="tm_<?php echo $this->_tpl_vars['tm']->getId(); ?>
_logo">
                            <a href="#" onclick="xajax_changeTMLogo(<?php echo $this->_tpl_vars['tm']->getId(); ?>
); return false;">Добавить/Изменить
                                лого</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            <tr>
                <td colspan="4" align="center" width="40">
                    <?php echo smarty_function_form_submit(array('value' => "Сохранить",'name' => "Сохранить"), $this);?>

                </td>
            </tr>
        </table>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_form($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

    </div>
</div>

<br/>

<div class="black_box mTop10 radius">
    <div class="inner">
        <div class="form">
            <div class="text">
                НОВАЯ ЗАПИСЬ
                <form method="POST" action="/admin/trademarks/" enctype="multipart/form-data">
                    <table width="300" style="width: 300px;">
                        <tr>
                            <td width="50%" class="tright">Название</td>
                            <td><?php echo smarty_function_form_text(array('name' => "trademarks[new][name]"), $this);?>
</td>
                        </tr>
                        <tr>
                            <td class="tright">Страна</td>
                            <td><?php echo smarty_function_form_select(array('id' => 'country','options' => $this->_tpl_vars['countries'],'name' => "trademarks[new][country_id]",'style' => "width: 150px;"), $this);?>
</td>
                        </tr>
                        <tr>
                            <td class="tright">Лого</td>
                            <td>
                                <input type="file" name="new"/>
                                <?php echo smarty_function_form_hidden(array('name' => "trademarks[new][logo_id]"), $this);?>

                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2"><input type="submit" name="submit" value="Добавить"></td>
                        </tr>
                    </table>
                </form>

            <?php echo '
                <script type="text/javascript">
                    function openMyDialog(id) {
                        $(\'#\' + id).modal();
                    }
                </script>
            '; ?>



            </div>
        </div>
    </div>
</div>