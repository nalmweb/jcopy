<fieldset>
<legend>Восстановление пароля</legend>
<form {$formNikname.attributes} class="fc">
{$formNikname.hidden}
{if $formNikname.errors}
   {foreach item=e from=$formNikname.errors}{$e}<br>{/foreach}
{/if}
<label>Восстановить по нику:</label>{$formNikname.nikname.html}
<div style="float:left">{submitbutton value="Восстановить пароль"}</div>
</form>
</fieldset>
<fieldset>
<div class="clear"><span /></div>
<form {$formLogin.attributes} class="fc">
{$formLogin.hidden}
{if $formLogin.errors}
   {foreach item=e from=$formLogin.errors}{$e}<br>{/foreach}
{/if}
<label>Восстановить по адресу почты:</label>{$formLogin.login.html} 
<div style="float:left">{submitbutton value="Восстановить пароль"}</div>
</form>
</fieldset> 
