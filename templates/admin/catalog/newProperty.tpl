<form id="newProperty">
<table cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td nowrap="true">Название</td>
			<td nowrap="true"><input type="text" value="" name="name"></td>
		</tr>
		<tr>
			<td nowrap="true">Ед. измерения</td>
			<td nowrap="true">
			<select name="ud" id="ud" style="width:80%;" >
             {foreach from=$udList key=udId item=ud}
             <option value="{$udId}" {if $data.ud == $udId} selected="selected"{/if}>{$ud}</option>
             {/foreach} 
            </select>
            </td>
		</tr>
		<tr>
			<td nowrap="true">Тип данных</td>
			<td nowrap="true">
		    <select name="pt" id="pt" >
             {foreach from=$propTypeList key=ptId item=ptl}
             <option value="{$ptId}" {if $data.pt == $ptId} selected="selected"{/if}>{$ptl}</option>
             {/foreach} 
            </select>
			</td>
		</tr>
		<tr>
			<td nowrap="true">Описание</td>
			<td nowrap="true"><textarea rows="2" name="description" ></textarea></td>
		</tr>
		<tr>
			<td nowrap="true" colspan="2">
			{linkbutton onclick="Dialog.cancelCallback()" name="Отмена" }
            {linkbutton onclick="xajax_addNewPropertyDo(xajax.getFormValues('newProperty')); return false;" name="Сохранить" }
            </td>
		</tr>
	</tbody>
</table>
</form>