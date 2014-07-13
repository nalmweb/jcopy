<div style="padding-top:50px;">
{include file="mailtemplates/_tabs.tpl"}
	
{contentblock width="100%"}
<center>
  <h2>Список шаблонов</h2>
</center>
<center>
  <table border=1>
    <tr>
      <td><b>Название шаблона</b></td>
      <td><b>Последнее изменение</b></td>
      <td><b>Описание</b></td>
      <td><b>Действия</b></td>
    </tr>
    {if $templatesList}
    {foreach item=mt from=$templatesList}
    <tr>
      <td>{$mt->templateName|escape:html}</td>
      <td align="center"> {if $mt->creator->login} <b>{$mt->creator->login}</b><br>
        ({$mt->changeDate})
        {else} Нет данных
        {/if} </td>
      <td>{if $mt->description}{$mt->description|escape:"html"|nl2br}{else}---{/if}</td>
      <td><a href="mailtpl/edit/{$mail_tpl_hash->id}">Изменить</a> :: <a href="mailtpl/delete/{$mail_tpl_hash->id}" onClick="return confirm('Вы уверены, что хотите удалить этот шаблон?');">Удалить</a> </td>
    </tr>
    {/foreach}
    {else}
    <tr>
      <td colspan="4" align="center">Нет записей</td>
    </tr>
    {/if}
  </table>
</center>
{/contentblock}
</div>