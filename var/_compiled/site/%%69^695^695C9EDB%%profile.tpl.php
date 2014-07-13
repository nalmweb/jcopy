<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:39
         compiled from users/profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'users/profile.tpl', 8, false),array('block', 't', 'users/profile.tpl', 48, false),)), $this); ?>
<?php if ($this->_tpl_vars['currentUser']->id == $this->_tpl_vars['user']->id): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "users/tabs.tpl", 'smarty_include_vars' => array('active' => 'profile')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
  
  <h1>Просмотр профиля</h1>
  <form class="fc">
  <fieldset>
	   <legend>Пользователь  <?php if ($this->_tpl_vars['currentUser']->getViewAs() == 1):  echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->getNikname())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html'));  else:  echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

               &#160;<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&#160;<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->middlename)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html'));  endif; ?></legend>
		<!--<h1><?php if ($this->_tpl_vars['currentUser']->view_as == 1):  echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->nikname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html'));  else:  echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

				<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html'));  echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->middlename)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html'));  endif; ?></h1>-->
		<?php if ($this->_tpl_vars['currentUser']->id == $this->_tpl_vars['user']->id): ?>
			<a href="<?php echo $this->_tpl_vars['currentUser']->getUserPath('avatars'); ?>
"><?php endif; ?>
			<img src="<?php echo $this->_tpl_vars['currentUser']->getAvatar()->getMedium(); ?>
" border="0" >
        <?php if ($this->_tpl_vars['currentUser']->id == $this->_tpl_vars['user']->id): ?>
            </a>
        <?php endif; ?>

		<?php if ($this->_tpl_vars['currentUser']->isOnline()): ?>
		  <br>Пользователь сейчас <span style="color: rgb(51, 153, 0);"><b>Online</b></span>
		<?php else: ?>
		  <br>Последняя активность <?php echo $this->_tpl_vars['currentUser']->getLastOnline(); ?>
 назад
		<?php endif; ?>
  </fieldset>

<fieldset>
<legend>Персональная информация</legend>
	<label for="nikname" class="required">Ник: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->nikname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php if ($this->_tpl_vars['currentUser']->lastname): ?>
	<label for="firstname">Имя: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['currentUser']->firstname): ?>
	<label for="lastname">Фамилия: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['currentUser']->middlename): ?>
	<label for="lastname">Отчество: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->middlename)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php endif; ?>
	<label for="sex" class="required">Пол: </label>
		<span class="profile_view"><?php if ($this->_tpl_vars['currentUser']->gender == 'male'): ?>
                                <?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Мужчина<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                            <?php else: ?>
                                <?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Женщина<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                            <?php endif; ?></span><br>

<?php if (! $this->_tpl_vars['currentUser']->getBirthdayPrivate()): ?>
	<label for="birthday" class="required">Дата рождения: </label>
	<span class="profile_view"><?php echo $this->_tpl_vars['birthday']; ?>
</span><br>
<?php endif; ?>
	<label for="country" class="required">Страна: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->getCountry()->name)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<label for="city" class="required">Город: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->getCity()->name)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php if ($this->_tpl_vars['currentUser']->getMetroId()): ?>
	<label for="metro">Ст. метро: </label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->getMetro()->name)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['currentUser']->street): ?>
     <label>Адрес:</label>
       <span class="profile_view"> <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->street)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->build)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->apartment)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
 </span><br />
    <?php endif; ?>
</fieldset>
    <fieldset>
        <legend class="required">О себе</legend>
        <?php if (! $this->_tpl_vars['custom_bike']): ?>
        <?php if (null !== $this->_tpl_vars['currentUser']->getBikeId()): ?>
            <label class="required">Я езжу на:</label> <span class="profile_view">
            	<?php echo $this->_tpl_vars['currentUser']->getBike()->getModel()->getTrademark()->getName(); ?>
 <?php echo $this->_tpl_vars['currentUser']->getBike()->getModel()->getName(); ?>
 <?php echo $this->_tpl_vars['currentUser']->getBike()->getYear(); ?>

	 </span><br />
        <?php endif; ?>
        <?php else: ?>
            <label class="required">Я езжу на:</label><span class="profile_view"><?php echo $this->_tpl_vars['custom_bike']; ?>
</span>
        <?php endif; ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->intro)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

    </fieldset>
    <?php if ($this->_tpl_vars['currentUser']->phone || $this->_tpl_vars['currentUser']->icq || $this->_tpl_vars['currentUser']->skype || $this->_tpl_vars['currentUser']->livejournal || $this->_tpl_vars['currentUser']->homepage || $this->_tpl_vars['currentUser']->msn): ?>
<fieldset>
<legend>Контактная информация</legend>
    <?php if ($this->_tpl_vars['currentUser']->icq): ?>
	<label for="icq">ICQ: </label>
		<span class="profile_view">
		<a href='http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->icq)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&action=message' onclick='window.open("http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->icq)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&action=message"); return false;'><img src="http://web.icq.com/whitepages/online?icq=<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->icq)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
&img=5" align="absmiddle" />
            <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->icq)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></span><br>
     <?php endif; ?>

	<?php if ($this->_tpl_vars['currentUser']->skype): ?>
	  <label for="skype">Skype: </label>
		<span class="profile_view"><a href="callto:<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->skype)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"><img src="http://mystatus.skype.com/smallicon/<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->skype)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" align="absmiddle">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->skype)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></span><br>
	<?php endif; ?>

    <?php if ($this->_tpl_vars['currentUser']->livejournal): ?>
	    <label for="livejournal">LiveJournal: </label>
		<span class="profile_view"><img src="http://stat.livejournal.com/img/userinfo.gif" align="absmiddle">
            <?php $this->_tag_stack[] = array('t', array()); $_block_repeat=true;smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>LiveJournal:<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_t($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->livejournal)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<br />
		</span><br>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['currentUser']->homepage): ?>
	<label for="homepage">Домашняя страница: </label>
	  <span class="profile_view">
       <a href="http://<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->homepage)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" target="_blank">http://<?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->homepage)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><br /></span><br>
    <?php endif; ?>

      <?php if ($this->_tpl_vars['currentUser']->msn): ?>
	    <label for="msn" >MSN: </label>
		  <span class="profile_view">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->msn)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<br /></span>
     <?php endif; ?>
   </fieldset>
 <?php endif; ?>
 <?php if ($this->_tpl_vars['currentUser']->getProfit() != 0 || $this->_tpl_vars['currentUser']->company || $this->_tpl_vars['currentUser']->post || $this->_tpl_vars['currentUser']->getUserUtilityes()): ?>
 <fieldset>
   <legend>Дополнительная информация</legend>
	<?php if ($this->_tpl_vars['currentUser']->getProfit() != 0): ?>
	<label for="profit">Сфера деятельности: </label>
		<span class="profile_view"><?php if ($this->_tpl_vars['currentUser']->getProfit()->name != ''):  echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->getProfit()->name)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
 <?php else: ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->getProfit()->groupName)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
 <?php endif; ?><br /></span>
   <br>
    <?php endif; ?>
   <?php if ($this->_tpl_vars['currentUser']->company): ?>
      <label for="company">Компания:</label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->company)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span> <br>
   <?php endif; ?>

   <?php if ($this->_tpl_vars['currentUser']->post): ?>
	    <label for="post">Должность:</label>
		<span class="profile_view"><?php echo ((is_array($_tmp=$this->_tpl_vars['currentUser']->post)) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><br>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['currentUser']->getUserUtilityes()): ?>
    <table cellpadding="0" cellspacing="0" border="0">
		<?php $_from = $this->_tpl_vars['currentUser']->getUserUtilityes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['util'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['util']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['utility']):
        $this->_foreach['util']['iteration']++;
?>
		  <tr><td><?php if (($this->_foreach['util']['iteration'] <= 1)): ?><label for="useful">Дополнительно:</label><?php else: ?>&nbsp;<?php endif; ?></td>
			<td><input type="checkbox" name="checkbox" id="checkbox" checked disabled/> <?php echo $this->_tpl_vars['utility']; ?>
</td>
		  </tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
	<?php endif; ?>
  </fieldset>
  <?php endif; ?>
      	 		    </form>

<a href="<?php echo $this->_tpl_vars['currentUser']->getUserPath('edit'); ?>
" id="edit" <?php if ($this->_tpl_vars['active'] == 'edit'): ?> class='active_link' <?php endif; ?> >Редактировать профиль</a> |
<a href="<?php echo $this->_tpl_vars['currentUser']->getUserPath('password'); ?>
" id="messages" <?php if ($this->_tpl_vars['active'] == 'password'): ?> class='active_link' <?php endif; ?>>Изменение пароля</a> |