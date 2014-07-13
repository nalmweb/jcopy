{if $user->uid != 1}{$tabs}{/if}
<center>
<h2>{t string="Add System Message"}</h2>
</center>

<form action={$form_action} method="POST">
<table border=1 width="400" align="center">

<tr><td>{t string="Message Template:"}</td>
<td>{form_textarea title='' name='m_text' value=`$m_text` cols='50' rows='10'}</td></tr>

<tr><td>{t string="Message Comment:"}</td>
<td>{form_textarea title='' name='m_comment' value=`$m_comment` cols='50' rows='3'}</td></tr>


<tr><td>&nbsp;</td>
<td>{theme function="submit_button" name="op" value="Save template" color="orange"}</td></tr>

</table>

</form>
