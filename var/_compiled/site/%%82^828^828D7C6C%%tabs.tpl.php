<?php /* Smarty version 2.6.16, created on 2014-07-13 14:23:17
         compiled from users/autohause/tabs.tpl */ ?>
Кабинет пользователя
<div>
  <a href="/users/">Каталоги</a>
  <a href="/users/">Баланс</a>
  <a href="<?php echo $this->_tpl_vars['currentUser']->getUserPath('profile'); ?>
" id="profile">Мой профиль</a>
  <a href="/users/logout/">Выход</a>
</div>
<br/>