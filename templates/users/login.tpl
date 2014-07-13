<div id="user_login">
		<div id="text">
			<form id="form1" {$loginFormData.attributes}>    
			{$loginFormData.login.html}<br />
			{$loginFormData.password.html}
		</div>
			<a href="{$SITE_NAME_AS_FULL_DOMAIN}/usersss/restore/">{t}Забыли пароль?{/t}</a>
			<span>{$loginFormData.submit.html}</span> 
			</form>

</div>