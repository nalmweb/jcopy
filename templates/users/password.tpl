{if $currentUser->id == $user->id}
    {include file="users/tabs.tpl" active="edit"}
{/if}

<div class="clear"><span /></div>
<h1>Изменение пароля</h1>


<br>
<form method="POST" action="/users/password/">
<input type="hidden" name="command" value="reset" > 
<table border="0"  width="50%" >
  <tr>
	<td>Введите Ваш новый пароль: </td>
	<td><input type="password" name="pwd" value="">
		<br><font style="color:#ff0000">{$message}</font>
	</td>
  </tr>
    <tr>
	<td>&nbsp</td>
	<td><input type="submit" name="Сохранить" value="Сохранить" >
	</td>
  </tr>
</table>
</form>
<div class="clear"><span /></div>