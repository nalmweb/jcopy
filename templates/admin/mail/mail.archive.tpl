
{include file='admin/menu.tpl'}

<br />

 
 <table>
  <tr>
     <td>Шаблон</td>
     <td>Дата</td>
     <td>Почта отправлена (кол-во пользователей)</td>
  </tr> 
  {foreach from=$list item=item}
    <tr>
      <td>
		{$item.template_name}
    </td>
    <td>
      {$item.reg_date|date_format:"%d.%M.%Y"}
    </td>
    <td>
      {$item.num_users}
    </td>
   </tr>
  {/foreach}
 </table>
 