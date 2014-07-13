{literal}
<script type="text/javascript">
    function uhnmb()
    {
        document.getElementById('myBike').style.display = 'none';
        document.getElementById('newBike').style.display = 'block';
    }
    function uhtfb()
    {
        document.getElementById('myBike').style.display = 'block';
        document.getElementById('newBike').style.display = 'none';
    }
</script>
{/literal}
{if $formContent.errors}
   {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}
{/if}
   
<form {$formContent.attributes} class="fc">
  <fieldset>
    <legend>Ввод регистрационной информации</legend>
    {$formContent.hidden}
  	<label for="email" class="required">Email:</label> {$formContent.login.html}<br />
  	<label class="required">{$formContent.nikname.label}</label> {$formContent.nikname.html}<br />
  	<label class="required">{$formContent.pass.label}</label> {$formContent.pass.html}<br />
  	<label class="required">Еще раз пароль:</label> {$formContent.pass_confirm.html}<br />
  	{*<label class="required">{$formContent.gender.male.label}</label> {$formContent.gender.male.html}Мужской {$formContent.gender.female.html}Женский<br>*}
    {*<label class="required">{$formContent.birthday.label}</label> {$formContent.birthday.html}<br />*}
  	{*<label>&#160;</label>{$formContent.birthdayPrivate.html} скрыть день рождения <br>*}

    {*<div id="myBike">
       <label class="required">Производитель:</label>{$formContent.marks.html}<br />
       <label class="required">Модель:</label> {$formContent.models.html}<br />
       <label class="required">Год выпуска:</label>{$formContent.years.html}<br />
       <label>&#160;</label><a href="#null" onclick="uhnmb(); return false;" id="text">я не нашел свою модель</a>
    </div>
  	<div id="newBike" style="display:none;">
  		{literal}
  		<label class="required">Я езжу на:</label> <input type="text" name="newBike" style="width:180px; color:#999999;" onfocus="if(this.value==''){this.value='производитель, модель, год'; this.style.color='#000000'}" onblur="if(this.value=='производитель, модель, год' ){this.value=''; this.style.color='#999999'}" value=""><br />
  		{/literal}
  		<label>&#160;</label><a href="#null" onclick="uhtfb(); return false;" id="text">вернуться к выбору из списка</a>
    </div>*}

    <br />

    {*<label class="required">Опыт вождения с:</label> {$formContent.experience.html}<br />*}

  	<label class="required">Страна:</label> {$formContent.countryId.html}{*form_select id="countryId" name="countryId" selected=$countryId options=$countries onchange="xajax_changeCountry(this.options[this.selectedIndex].value);" style="width: 207px;"*}<br />
    <label class="required">Город:</label> {$formContent.cityId.html}{*form_select id="cityId" name="cityId" selected=$cityId options=$cities onchange="xajax_changeCity(this.options[this.selectedIndex].value);" style="width: 207px;"*}<br />
    <label>Метро (если есть):</label> {$formContent.metroId.html}{*form_select selected=$metroId id="metroId" name="metroId" options=$metroes style="width: 207px;"*}<br />
    <label>&nbsp;</label><br /><center>{$formContent.verify_image.html}</center><br />
  	<label class="required">{$formContent.verify_code.label}</label> {$formContent.verify_code.html} <br />
  	<label>&nbsp;</label>{$formContent.agree.label} {$formContent.agree.html}<br>
  	<label>&nbsp;</label><div>{submitbutton value="Зарегистрироваться"}</div>
  </fieldset>

  <br /><br /><br />
</form>