{strip}
<fieldset>
<legend>Спасибо за регистрацию!</legend>
<div align=center>
		<table width=100%><tr><td align=center>
		{if $fromRegistration}
		<h4>{$userData.login}, добро пожаловать к {$SITE_NAME}</h4>
		{else}
		<h4>Спасибо, мы обрабатываем Ваш запрос.</h4>
		{/if}
  		<br>
  		<div class="arrow" align=left style="width:250px;">
  		Подтверждающее письмо было выслано на адрес {$userData.login}. Пожалуйста, прочтите письмо и следуйте инструкциям чтобы активировать вашу учетную запись.
  		</div>
		</td></tr></table>
	</div>
</fieldset>
{/strip}