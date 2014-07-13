{strip}
		<form {$formContent.attributes} class="fc">
		<fieldset>
		<legend>Напоминание регистрационного кода</legend>
			{$formContent.hidden}
			{if $formContent.errors}
			   {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}
			{/if}  			    
  				<label>Логин:</label>{$formContent.login.html}<br />
  				<label>Пароль:</label>{$formContent.pass.html}<br />
  				<div style="float:center">{submitbutton value="Послать"}</div>
  		</fieldset>	
{/strip}