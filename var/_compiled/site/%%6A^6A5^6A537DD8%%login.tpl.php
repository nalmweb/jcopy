<?php /* Smarty version 2.6.16, created on 2014-07-13 12:35:35
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'submitbutton', 'login.tpl', 15, false),)), $this); ?>
<div class="user" style="float:right;padding: 7px; position: absolute; right: 0; background-color: #FFF">
 <form id="login_form"  <?php echo $this->_tpl_vars['loginFormData']['attributes']; ?>
 >
	 <?php echo $this->_tpl_vars['loginFormData']['hidden']; ?>

        <table width="206">
          <tr>
            <td width="83">
            <?php echo '
            <input type="text" name="login" class="in" style="width: 100px; color:#999999;" onfocus="if(this.value==\'e-mail\'){this.value=\'\'; this.style.color=\'#000000\'}" onblur="if(this.value==\'\' ){this.value=\'e-mail\'; this.style.color=\'#999999\'}" value="e-mail" />
            '; ?>

            </td>
            <td width="111" style="font-size:12px">&nbsp;&nbsp;<?php echo $this->_tpl_vars['loginFormData']['rememberme']['html']; ?>
</td>
          </tr>
          <tr>
            <td><?php echo $this->_tpl_vars['loginFormData']['password']['html']; ?>
</td>
            <td><span><?php echo smarty_function_submitbutton(array('name' => 'Login','value' => "Войти"), $this);?>
</span></td>
          </tr>
          <tr>
            <td colspan="2"><a href="/registration/">регистрация</a> / <a href="/users/restore/">забыл пароль?</a></td>
          </tr>
        </table>
      </form>
      <div id="clear"></div>	   
</div>