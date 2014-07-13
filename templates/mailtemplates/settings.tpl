{include file="mailtemplates/_tabs.tpl"}

{contentblock width="100%"}


<h2>Settings</h2><br>
<center>
{$SITE_NAME_AS_STRING} users who has access to mailtpl module.
</center>
<br>
{$formContent}
<br>
<table border=1 align="center" width="100%">
<tr>
<td><strong>Login</strong></td>
<td><strong>Actions</strong></td>
</tr>
{foreach item=ac from=$accessList}
<tr>
	<td>{$ac->login}</td>
	<td><a href="{if $USE_USER_PATH}{$use_user_path}{$LOCALE}{else}{$LOCALE}{$MOD_NAME}{/if}/deleteuser/id/{$ac->id}/" onClick="return confirm('Are you sure you want to remove this user?');">Delete</a>
	
	</td>
</tr>
{/foreach}
</table>

{/contentblock}