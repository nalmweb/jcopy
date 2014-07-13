<h2><a onclick="new Effect.toggle($('powersearch'),'blind')" style="cursor: pointer;">Расширенный поиск по автомобилям</a> <img src="/images/icons/zoom.png" class="png" align="absmiddle" /></h2>
<br />
<div id="powersearch" style="display: none;">
<form class="fc" action="/board/searchauto/" method="POST" name="search_bikes" target="_self">
<fieldset style="width: 400px;">

<label>Марка:</label>
<select name="markId" style="width:150px;" id="markId" onclick="xajax_changeTrademarkSearch(this.options[this.selectedIndex].value);">
 {html_options values=$mark_ids selected=$selectedMarkId output=$mark_names}
</select>
<br/>
<label>Модель:</label>
<select name="modelId" style="width:150px;" id="modelId">
  {if !empty($models_ids)}
	 {html_options values=$models_ids selected=$selectedModelId output=$models_names}
  {/if}
</select>
<br/>
<label>Тип:</label>
<select name="typeId" style="width:150px;" id="typeId">
	{html_options values=$type_ids selected=$type_id output=$type_names}
</select>
<br/>
<label>Цена:</label>
<input type="text" value="{$search.price.from}" name="price[from]" size="7" maxlength="7"/>–<input type="text" value="{$search.price.to}" name="price[to]" size="7" maxlength="7"/>
<br/>
<label>Пробег, км:</label>
<input type="text" value="{$search.probeg.from}" name="probeg[from]" size="7" maxlength="7"/>–<input type="text" value="{$search.probeg.to}" name="probeg[to]" size="7" maxlength="7"/>
<br/>
<label>Год выпуска:</label>

<input type="checkbox" onclick="do_enable('year_from');do_enable('year_to');" />

<select name="year[from]" style="width:68px;" id="year_from" disabled="false">
   {foreach from=$years item=item key=key}
    {if $item==1996 }
	  <option value="{$item}" selected="selected">{$item}</option>
	{else}
	  <option value="{$item}">{$item}</option>
	{/if}	  
   {/foreach}
 </select>
  
 </select>-<select name="year[to]" style="width:68px;" id="year_to" disabled="disabled">
  {foreach from=$years item=item key=key}
    {if $item==$cur_year }
	  <option value="{$item}" selected="selected">{$item}</option>
	{else}
	  <option value="{$item}">{$item}</option>
	{/if}	  
   {/foreach}
 </select>
<br/>
<label>только с фото:</label>
<input type="checkbox" name="is_photo" value="{$search.is_photo|default:1}" >
<br/>
<label></label> {submitbutton name="save" value="Искать"}
</fieldset>
</form>
</div>