Настройка дополнительных возможностей покупки: <br>

{form from=$form}
  {foreach from=$price item=u key=id}
    <input type="text" name="price[{$u.id}]" value="{$u.name}" />
    <select name="status[{$u.id}]" id="status_{$u.id}">
    {if ($u.status == 'true')}
      <option value='true' selected="selected">true</option>
      <option value='false'>false</option>
    {else}
      <option value='false' selected="selected">false</option>
      <option value='true'>true</option>
    {/if}
    </select>
    <br />
  {/foreach}

  <br><br>
  Новый:<br>
  <input name="price[new]" value="" type="text">

  По умолчанию:
  <select name="priceParam[new]" size="1">
    <option value="true">true</option>
    <option value="false" selected="selected">false</option>
  </select>

  <br>

  {form_submit value="Сохранить"}
{/form}