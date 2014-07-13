<table width="500px;" border="0">
<tr>
 {assign var=count value=1}
 {foreach from=$models item=model}
<td><a href="/board/cat/{$cat_id}/trademark/{$tm->getName()}/model/{$model->getName()}/">{$model->getName()}</a>
</td>
    {if $count%5==0}
     </tr><tr> 
    {/if}
   {assign var=count value=$count+1}
 {/foreach}
</tr>
</table>