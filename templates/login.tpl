<div class="user" style="float:right;padding: 7px; position: absolute; right: 0; background-color: #FFF">
 <form id="login_form"  {$loginFormData.attributes} >
	 {$loginFormData.hidden}
        <table width="206">
          <tr>
            <td width="83">
            {literal}
            <input type="text" name="login" class="in" style="width: 100px; color:#999999;" onfocus="if(this.value=='e-mail'){this.value=''; this.style.color='#000000'}" onblur="if(this.value=='' ){this.value='e-mail'; this.style.color='#999999'}" value="e-mail" />
            {/literal}
            {*$loginFormData.login.html*}</td>
            <td width="111" style="font-size:12px">&nbsp;&nbsp;{$loginFormData.rememberme.html}</td>
          </tr>
          <tr>
            <td>{$loginFormData.password.html}</td>
            <td><span>{submitbutton name="Login" value="Войти"}</span></td>
          </tr>
          <tr>
            <td colspan="2"><a href="/registration/">регистрация</a> / <a href="/users/restore/">забыл пароль?</a></td>
          </tr>
        </table>
      </form>
      <div id="clear"></div>	   
</div>
