    {if $currentUser->id == $user->id}
        {include file="users/tabs.tpl" active="edit"}
    {/if}
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
    <div class="clear"><span /></div>
    <h1>Редактрирование профиля {$currentUser->login|escape:"html"}</h1>
    <form {$formContent.attributes} class="fc"> 
    <fieldset>
    <legend>Аватар пользователя</legend>
		<img src="{$currentUser->getAvatar()->getMedium()}" border="0" width="75">
		<br/>
		<a href="{$currentUser->getUserPath('avatars')}">
			изменить аватар
		</a>
	</fieldset>	
		{$formContent.hidden}
  <fieldset>
        <legend>Персональная информация</legend>
		<label for="nikname" class="required">Ник: </label>
			<span class="profile_view">{$currentUser->nikname|escape:"html"}</span><br>
	    <label>Имя:</label> {$formContent.lastname.html}<br />
        <label>Фамилия:</label> {$formContent.firstname.html}<br />
		<label>Отчество:</label> {$formContent.middlename.html}<br />
 {*		<label>Отображать как:</label>
		<select name="view_as">
				<option value="1" {if $currentUser->view_as == 1}selected="selected"{/if}>{$currentUser->nikname|escape:"html"}</option>
				<option value="2" {if $currentUser->view_as == 2}selected="selected"{/if}>{$currentUser->firstname|escape:"html"} {$currentUser->lastname|escape:"html"} {$currentUser->middlename|escape:"html"}</option>
		</select><br />
*}
		<label class="required">Пол:</label> {$formContent.gender.html}<br />
		<label class="required">Дата рождения:</label> {$formContent.birthday.html}<br>
  	    <label>&#160;</label>{$formContent.birthdayPrivate.html} скрыть день рождения <br>
   </fieldset>
   <fieldset>
        <legend class="required">О себе</legend>
    
    <div id="myBike" {if $custom_bike} style="display:none;"{/if}>
     <label class="required">Производитель:</label>{$formContent.marks.html}<br />
     <label class="required">Модель:</label> {$formContent.models.html}<br />
     <label class="required">Год выпуска:</label>{$formContent.years.html}<br />
     <label></label><a href="#null" onclick="uhnmb(); return false;" id="text">я не нашел свою модель</a><br/>
     </div>
    <div id="newBike" {if !$custom_bike}style="display:none;"{/if}>
    <label class="required">Я езжу на:</label> <input type="text" name="newBike" value="{$custom_bike}">
    <a href="#null" onclick="uhtfb(); return false;">вернуться к выбору из списка</a><br/>
    </div>
    <br />
        {$formContent.intro.html}
    </fieldset>
   <fieldset>
        <legend>Адрес</legend>            
        <label class="required">Страна:</label> {$formContent.countryId.html}<br />
        <label class="required">Город:</label> {$formContent.cityId.html}<br />
        <label>ст. метро:</label> {$formContent.metroId.html}<br />
        <label>{$formContent.street.label}</label>  {$formContent.street.html}<br>
        <label>{$formContent.build.label}</label> {$formContent.build.html}<br> 
        <label>{$formContent.apartment.label}</label> {$formContent.apartment.html}
    </fieldset>
  <fieldset>
		<legend>Контактная информация</legend>
		<label>{$formContent.skype.label}</label> {$formContent.skype.html}<br />
		<label>{$formContent.icq.label}</label> {$formContent.icq.html}<br />
		<label>{$formContent.msn.label}</label> {$formContent.msn.html}<br />
		<label>{$formContent.livejournal.label}</label> {$formContent.livejournal.html}<br />
		<label>{$formContent.homepage.label}</label> &nbsp; http://{$formContent.homepage.html}<br />
		<label>{$formContent.phone.label}</label> {$formContent.phone.html}<br />
    </fieldset>
    <fieldset>
		<legend>Дополнительная информация</legend>
        <label>Сфера деятельности:</label>{$formContent.profit.html}<br />
        <label>Компания:</label> {$formContent.company.html}<br />
        <label>Должность:</label> {$formContent.post.html}<br />
        <label>Дополнительно:</label><div id="clear"></div>{$formContent.utilityes.html}<br />
     </fieldset>


    <div class="clear"></div>
		<center>{submitbutton name="save" value="Сохранить"}</center>
	</form>