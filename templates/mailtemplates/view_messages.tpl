{include file="mailtemplates/_tabs.tpl"}

{contentblock width="100%"}
<center>
  <h2>View System Messages list</h2>
</center>
<center>
  <table border=1 width="450">
    <tr>
      <td width="30"><b>ID</b></td>
      <td width="170"><b>Last Edit</b></td>
      <td width="200"><b>Description</b></td>
      <td width="70"><b>Actions</b></td>
    </tr>
    {if $messagesList}
    {foreach item=mt from=$messagesList}
    <tr>
      <td>{$mt->id}</td>
      <td><b>{$mt->changer->login}</b> ({$mt->changeDate})</td>
      <td>{$mt->description}</td>
      <td><a href="mailtpl/edit_message/{$messages_hash[message].m_id}">Edit</a> :: <a href="mailtpl/delete_message/{$messages_hash[message].m_id}" onClick="return confirm('Are you sure you want to delete this message?');">Delete</a> </td>
    </tr>
    {/foreach}
    {else}
    <tr>
      <td colspan="4" align="center">No Records</td>
    </tr>
    {/if}
  </table>
</center>
{/contentblock}
