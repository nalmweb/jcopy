<div id='msg'>
 <div id="window_title">Изменить параметры</div><br>
 Для удаления параметра достаточно очистить поле с ненужным значением.
 <form action="" id='data_property'>
 <input type="hidden" name="prop_id" value="{$prop_id}">
 {foreach from=$values key=k item=l}
    <input type="text" name="{$k}" value="{$l}"><br />  
 {/foreach}
 <input type="text" name="new" value="">
 </form>
  <div class="buttons-pannel-pop">
   <div style="margin-right:0px;">
    {linkbutton onclick="$.modal.close(); return false;" name="Отмена" }
    {linkbutton onclick="xajax_addPropertyValue(xajax.getFormValues('data_property')); return false;" name="Сохранить" }
    {linkbutton onclick="xajax_addPropertyValue(xajax.getFormValues('data_property'), 'new'); return false;" name="Сохранить и добавить еще" }
   </div>
   </div>
</div>