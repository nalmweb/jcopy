{if $currentUser->id == $user->id}
	{include file="users/tabs.tpl" active="profile"}
{/if}

{$js}


<div id="ajaxContent" style="display:none">{$ajaxContent}</div>

{literal}
<style>
.hid{display:none;}
.show{display:inline;}
</style>
<script>
  function showField(id){
	 $(id).className = 'show';
  }
  function hideField(id){
  	//$(id).className = 'show';
  	$(id).className = 'hid';
  }	 
</script>
{/literal}

<h1> Изменение объявления (продажа мотоцикла) </h1>
<div><br>
 <form {$formContent.attributes} class="fc">
 {$formContent.hidden}
  {if $formContent.errors}
     {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}
  {/if}
<fieldset style="width:650px;">
   <legend>Продажа мотоцикла:</legend>
   	 <label class="required">Заголовок<sup>*</sup>:</label>{$formContent.title.html}<br />
	 <label class="required">Производитель:<sup>*</sup>:</label>{$formContent.markId.html}
      <br />
	 <div id="custom_name" class="hid"><label>Укажите модель:</label>
	 <input type="text" value="" name="custom_name" >
	 </div>
	 <br />
	 <label class="required">Модель<sup>*</sup>:</label>{$formContent.modelId.html} <a href="/feedback/" target="_blank">заявка на добавление новой модели</a><br/>
	 <label class="required">Год выпуска<sup>*</sup>:</label>{$formContent.yearId.html}<br />
	 <label class="required">Тип<sup>*</sup>:</label>{$formContent.typeId.html}<br />
	 <label class="required">Объем<sup>*</sup>:</label>{$formContent.volume.html}<br />
	 <label class="required">Мощность:</label>{$formContent.power.html}<br />
	 <label class="required">Пробег:</label>{$formContent.probeg.html}<br />
	 <label class="required">КПП:</label>{$formContent.kpp.html}<br />
	 <label class="required">Состояние<sup>*</sup>:</label>{$formContent.condition.html}<br />
	 <label class="required">Страна<sup>*</sup>:</label>{$formContent.countryId.html}
	 <br />
	 <label class="required">Город<sup>*</sup>:</label>{$formContent.cityId.html}
	  <br />
	  <label class="required">Цена<sup>*</sup>:</label>{$formContent.price.html}&nbsp;Валюта:Российский рубль.{*$formContent.currencyId.html*}<br /> 
	  <label>С торгом</label>{$formContent.is_torg.html}
	 <br />	
 </fieldset>
   <br>
   <fieldset> 
	  <legend>Описание:</legend> {$formContent.content.html}
   </fieldset>
   
   <fieldset> 
	  <legend>Контакты:</legend> 
	  <label>Телефон:</label>{$formContent.phone.html}<br>
	  <label>ICQ:</label>{$formContent.icq.html}<br>
	  <label>Skype:</label>{$formContent.skype.html}<br>
   </fieldset>
   
<div class='clear' style="padding:10px;">&#160;</div>
   
  <fieldset>
	 <legend>Фотографии:</legend>  <br>

<!-- delete photo, change photo -->
<table>
<tr><td>
<div id="message" style="background-color:#000000;height:30px;width:150px;display:none;"></div>
</td></tr>
</table>
 <table border="1" id="parent" >
  {if !empty($photos)}
  {foreach from=$photos item=photo}
   <tr id="row_{$photo.id}"     >
   <td><img src="{$photo.small}?{$rand}" /></td>
   <td>
     <input type="button" name="change" value="Заменить" onclick="xajax_changePhotoDialog({$photos_type},{$item_id},{$photo.id},{$cat_id}); return false;" ></td>
   <td><img src="/images/del.png" class="png" onclick="xajax_delPhoto({$photos_type},{$item_id},{$photo.id})"></td>
   </tr>  
 {/foreach}
 {/if} 
</table>	 
  <div class="photos"> </div>
		{assign var=count value=0 }
		{section name=photo loop=$maxPhotos-$numPhotos start=0 max=$maxPhotos-$numPhotos}
   	   	  <div><input name="photo_{$count}" type="file" /><div><br />
			{assign var=count value=$count+1 }
   	    {/section}
  </div>
  <div style="padding-left:140px;padding-top:20px;">{submitbutton value="Сохранить" }</div>
	</div>
  </fieldset>
  <br>
  <input type="hidden" name="h_year" value="" id="h_year">
  <input type="hidden" name="isYear" value="false" id="isYear">
</form>
</div>