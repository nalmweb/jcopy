<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:39
         compiled from logged.tpl */ ?>
<div id="user" style="float:right;padding: 7px; position: absolute; right: 0; background-color: #FFF">
		<div style="float:left;"><img id="user_icon" src="<?php echo $this->_tpl_vars['user']->getAvatar()->getSmall(); ?>
"></div>
		<div id="text" style="float:left;padding-left:3px;">
			Привет, <?php echo $this->_tpl_vars['user']->nikname; ?>
<br />
						<a href="http://<?php echo $this->_tpl_vars['BASE_HTTP_HOST']; ?>
/users/">Кабинет</a> |
			<a href="http://<?php echo $this->_tpl_vars['BASE_HTTP_HOST']; ?>
/users/logout/">Выход </a>
		</div>		
</div>
<div id="clear"></div>