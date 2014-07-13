<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:39
         compiled from users/tabs.tpl */ ?>
Кабинет пользователя
<div>
  <a href="/users/ads"  <?php if ($this->_tpl_vars['active'] == 'ads'): ?> class='active_link' <?php endif; ?> >Мои обьявления</a>
  <a href="<?php echo $this->_tpl_vars['currentUser']->getUserPath('profile'); ?>
" id="profile"  >Мой
    профиль</a>
  <a href="/users/logout/">Выход</a>
</div>
<br/>