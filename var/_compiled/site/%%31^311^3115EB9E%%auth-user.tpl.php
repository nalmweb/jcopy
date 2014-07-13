<?php /* Smarty version 2.6.16, created on 2014-07-12 16:46:43
         compiled from admin/auth-user.tpl */ ?>
<div class="auth-usr">
    <div class="inner"><i>кабинет суперадминистратора</i>
        <div class="auth-right"></div>
        <a class="i_usr" href="/users/profile/userid/<?php echo $this->_tpl_vars['user']->getId(); ?>
/"><?php echo $this->_tpl_vars['user']->nikname; ?>
</a>
        <img class="link_tr" src="/images/admin/link_tr.jpg" alt="" />
        <a class="i_log" href="http://<?php echo $this->_tpl_vars['BASE_HTTP_HOST']; ?>
/cp">Кабинет администратора</a>
        <img class="link_tr" src="/images/admin/link_tr.jpg" alt="" />
        <a class="i_log" href="http://<?php echo $this->_tpl_vars['BASE_HTTP_HOST']; ?>
/users/logout/">Выйти</a>
    </div>
</div>