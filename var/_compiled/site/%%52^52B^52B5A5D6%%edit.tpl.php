<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:45
         compiled from users/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'users/edit.tpl', 20, false),array('function', 'submitbutton', 'users/edit.tpl', 92, false),)), $this); ?>
    <?php if ($this->_tpl_vars['currentUser']->id == $this->_tpl_vars['user']->id): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "users/tabs.tpl", 'smarty_include_vars' => array('active' => 'edit')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    <?php echo '
<script type="text/javascript">
    function uhnmb()
    {
        document.getElementById(\'myBike\').style.display = \'none\';
        document.getElementById(\'newBike\').style.display = \'block\';
    }
    
    function uhtfb()
    {
        document.getElementById(\'myBike\').style.display = \'block\';
        document.getElementById(\'newBike\').style.display = \'none\';
    }
</script>
'; ?>

    <div class="clear"><span /></div>
    <h1>Редактрирование профиля <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->login)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</h1>
    <form <?php echo $this->_tpl_vars['formContent']['attributes']; ?>
 class="fc"> 
    <fieldset>
    <legend>Аватар пользователя</legend>
		<img src="<?php echo $this->_tpl_vars['currentUser']->getAvatar()->getMedium(); ?>
" border="0" width="75">
		<br/>
		<a href="<?php echo $this->_tpl_vars['currentUser']->getUserPath('avatars'); ?>
">
			изменить аватар
		</a>
	</fieldset>	
		<?php echo $this->_tpl_vars['formContent']['hidden']; ?>

  <fieldset>
        <legend>Персональная информация</legend>
		<label for="nikname" class="required">Ник: </label>
			<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->nikname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	    <label>Имя:</label> <?php echo $this->_tpl_vars['formContent']['lastname']['html']; ?>
<br />
        <label>Фамилия:</label> <?php echo $this->_tpl_vars['formContent']['firstname']['html']; ?>
<br />
		<label>Отчество:</label> <?php echo $this->_tpl_vars['formContent']['middlename']['html']; ?>
<br />
 		<label class="required">Пол:</label> <?php echo $this->_tpl_vars['formContent']['gender']['html']; ?>
<br />
		<label class="required">Дата рождения:</label> <?php echo $this->_tpl_vars['formContent']['birthday']['html']; ?>
<br>
  	    <label>&#160;</label><?php echo $this->_tpl_vars['formContent']['birthdayPrivate']['html']; ?>
 скрыть день рождения <br>
   </fieldset>
   <fieldset>
        <legend class="required">О себе</legend>
    
    <div id="myBike" <?php if ($this->_tpl_vars['custom_bike']): ?> style="display:none;"<?php endif; ?>>
     <label class="required">Производитель:</label><?php echo $this->_tpl_vars['formContent']['marks']['html']; ?>
<br />
     <label class="required">Модель:</label> <?php echo $this->_tpl_vars['formContent']['models']['html']; ?>
<br />
     <label class="required">Год выпуска:</label><?php echo $this->_tpl_vars['formContent']['years']['html']; ?>
<br />
     <label></label><a href="#null" onclick="uhnmb(); return false;" id="text">я не нашел свою модель</a><br/>
     </div>
    <div id="newBike" <?php if (! $this->_tpl_vars['custom_bike']): ?>style="display:none;"<?php endif; ?>>
    <label class="required">Я езжу на:</label> <input type="text" name="newBike" value="<?php echo $this->_tpl_vars['custom_bike']; ?>
">
    <a href="#null" onclick="uhtfb(); return false;">вернуться к выбору из списка</a><br/>
    </div>
    <br />
        <?php echo $this->_tpl_vars['formContent']['intro']['html']; ?>

    </fieldset>
   <fieldset>
        <legend>Адрес</legend>            
        <label class="required">Страна:</label> <?php echo $this->_tpl_vars['formContent']['countryId']['html']; ?>
<br />
        <label class="required">Город:</label> <?php echo $this->_tpl_vars['formContent']['cityId']['html']; ?>
<br />
        <label>ст. метро:</label> <?php echo $this->_tpl_vars['formContent']['metroId']['html']; ?>
<br />
        <label><?php echo $this->_tpl_vars['formContent']['street']['label']; ?>
</label>  <?php echo $this->_tpl_vars['formContent']['street']['html']; ?>
<br>
        <label><?php echo $this->_tpl_vars['formContent']['build']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['build']['html']; ?>
<br> 
        <label><?php echo $this->_tpl_vars['formContent']['apartment']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['apartment']['html']; ?>

    </fieldset>
  <fieldset>
		<legend>Контактная информация</legend>
		<label><?php echo $this->_tpl_vars['formContent']['skype']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['skype']['html']; ?>
<br />
		<label><?php echo $this->_tpl_vars['formContent']['icq']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['icq']['html']; ?>
<br />
		<label><?php echo $this->_tpl_vars['formContent']['msn']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['msn']['html']; ?>
<br />
		<label><?php echo $this->_tpl_vars['formContent']['livejournal']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['livejournal']['html']; ?>
<br />
		<label><?php echo $this->_tpl_vars['formContent']['homepage']['label']; ?>
</label> &nbsp; http://<?php echo $this->_tpl_vars['formContent']['homepage']['html']; ?>
<br />
		<label><?php echo $this->_tpl_vars['formContent']['phone']['label']; ?>
</label> <?php echo $this->_tpl_vars['formContent']['phone']['html']; ?>
<br />
    </fieldset>
    <fieldset>
		<legend>Дополнительная информация</legend>
        <label>Сфера деятельности:</label><?php echo $this->_tpl_vars['formContent']['profit']['html']; ?>
<br />
        <label>Компания:</label> <?php echo $this->_tpl_vars['formContent']['company']['html']; ?>
<br />
        <label>Должность:</label> <?php echo $this->_tpl_vars['formContent']['post']['html']; ?>
<br />
        <label>Дополнительно:</label><div id="clear"></div><?php echo $this->_tpl_vars['formContent']['utilityes']['html']; ?>
<br />
     </fieldset>


    <div class="clear"></div>
		<center><?php echo smarty_function_submitbutton(array('name' => 'save','value' => "Сохранить"), $this);?>
</center>
	</form>