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
<h1><a href="/">{$crumbs[0]}</a>  / <a href="/board/">{$crumbs[1]}</a> / Продать </h1>
<div><br>
 <div id="MSGID"></div>
 <form {$formContent.attributes} class="fc" >
 {$formContent.hidden}
  {if $formContent.errors}
     {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}
  {/if}
  <fieldset style="width:650px;">
     <legend>Продажа автомобиля:</legend>
     	 <label class="required">Заголовок<sup>*</sup>:</label>{$formContent.title.html}<br />
  	 <label class="required">Производитель:<sup>*</sup>:</label>{$formContent.markId.html}
  	 <!-- <input type="button" name="n" value="Другой" onclick="showField('custom_name')"> -->
        <br />
  	 <div id="custom_name" class="hid"><label>Укажите модель:</label>
  	 <input type="text" value="" name="custom_name" >
  	 <!-- <a href="javascript:hideField('custom_name')">[X-Закрыть]</a> -->
  	 </div>
  	 <br />
  	 <label class="required">Модель<sup>*</sup>:</label>{$formContent.modelId.html} <a href="/feedback/" target="_blank">заявка на добавление новой модели</a><br/>

     <label class="required">Модификация<sup>*</sup>:</label><input type="text"><br/>

     <label class="required">Год выпуска<sup>*</sup>:</label>{$formContent.year.html}<br />

     {*<label class="required">Тип<sup>*</sup>:</label>{$formContent.typeId.html}<br />*}
     <label class="required">Тип двигателя<sup>*</sup>:</label>{$formContent.typeId.html}<br />

     <label class="required">Объем<sup>*</sup>:</label>{$formContent.volume.html}<br />

     <label class="required">Мощность:</label>{$formContent.power.html}<br />

     <label class="required">Пробег:</label>{$formContent.probeg.html}<br />

     <label class="required">Коробка передач:</label>{$formContent.kpp.html}<br />

     <label class="required">Вид автоматической КПП:</label>{$formContent.kppVid.html}<br />

     <label class="required">Кол-во ступеней КПП:</label>{$formContent.kppStup.html}<br />

     <label class="required">Кап. ремонт:</label>{$formContent.kapRemont.html}<br />
     <label class="required">Мест:</label>{$formContent.places.html}<br />
     <label class="required">Двери:</label>{$formContent.dveri.html}<br />

     <label class="required">Привод:</label>{$formContent.privod.html}<br />
     <label class="required">Кузов:</label>{$formContent.kuzov.html}<br />
     <label class="required">Цвет:</label>{$formContent.color.html}<br />

     <label class="required">Состояние<sup>*</sup>:</label>{$formContent.condition.html}<br />

     <label class="required">Страна<sup>*</sup>:</label>{$formContent.countryId.html}

     <br />

     <label class="required">Город<sup>*</sup>:</label>{$formContent.cityId.html}
  	  <br />
  	  <label class="required">Цена<sup>*</sup>:</label>{$formContent.price.html}&nbsp;Валюта:Jcopy.{*$formContent.currencyId.html*}<br />
  	  <label>С торгом</label>{$formContent.is_torg.html}<br>

        {foreach from=$prices item=u key=id}
          {if ($u.status == 'false')}
            <label>{$u.name}</label><input type="checkbox" name="prices[{$u.id}]" value="true"/><br>
          {else}
            <label>{$u.name}</label><input type="checkbox" name="prices[{$u.id}]" value="true" checked="checked" /><br>
          {/if}
        {/foreach}


  	 <br />
   </fieldset>

   <fieldset>
	  <legend>Дополнительные опции:</legend>
    {foreach from=$options item=u key=id}
      {if ($u.status == 'false')}
        <input type="checkbox" name="options[{$u.id}]" value="true"/>{$u.name}
      {else}
        <input type="checkbox" name="options[{$u.id}]" value="true" checked="checked" />{$u.name}
      {/if}
      <br />
    {/foreach}
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

  <fieldset>
	 <legend>Фотографии:</legend>  <br>
	  	{$formContent.photo_0.html}<br>
	  	{$formContent.photo_1.html}<br>
	  	{$formContent.photo_2.html}<br>
	  	{$formContent.photo_3.html}<br>
	  	{$formContent.photo_4.html}<br>
  </fieldset>

   <fieldset>
     <legend>Ускорить продажу (платные услуги):</legend>
     1. Расклейка обьявлений на подьездах<br>
     2. Мы заспамим все почтовые ящики города<br>
   </fieldset>

  <br>{submitbutton value="Добавить" class="RightButton"}
  <input type="hidden" name="h_year" value="" id="h_year">
  <input type="hidden" name="isYear" value="false" id="isYear">
</form>
</div>
