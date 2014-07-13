<table border="0" width="80%">
<tr>
{assign var=count value=1}
{foreach from=$modelsList item=item key=key}
   <td>
	 <a href="/board/listauto/trademark/{$trademark_name}/model/{$item}">{$item}</a>&nbsp;
   </td>
   {if $count%7==0} 
   	  </tr><tr>
   {/if}
 {assign var=count value=$count+1}   
{/foreach}
 </tr>
</table>