{if $user->uid != 1}{$tabs}{/if}
<center>
  <h2>Добавить шаблон</h2>
</center>
<form action="/mailtemplates/addtpl/" method="POST" name="form0" id="form0">
  <table border=1 width="470" align="center">
    <tr>
      <td>Название файла шаблона:<br>
        (например, new_mail.tpl)</td>
      <td><input name="mail_template" value="{$mail_template}" size='68'></b></td>
    </tr>
    <tr>
      <td>Кому:</td>
      <td><input name="mail_to" value="{$mail_to}" size='68'></td>
    </tr>
    <tr>
      <td>От кого:</td>
      <td><input name="mail_from" value="{$mail_from}" size='68'></td>
    </tr>
    <tr>
      <td>Тема:</td>
      <td><input name="mail_subject" value="{$mail_subject}" size='68'></td>
    </tr>
    <tr>
      <td>Сообщение:{t string="Message field:"}{/t}</td>
      <td><textarea name="mail_message" rows="10" cols="65" value="{$mail_message}"></textarea></td>
    </tr>
    <tr>
      <td>Описание:</td>
      <td><textarea name="mail_comment" rows="2" cols="65" value="{$mail_comment}"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>{submitbutton color="orange" name='Сохранить' id='op'}
      		{submitbutton name="Предпросмотр" id="op" attributes=`$preview_attr`}
	  </td>
    </tr>
  </table>
</form>
