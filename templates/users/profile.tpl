{if $currentUser->id == $user->id}
	{include file="users/tabs.tpl" active="profile"}
{/if}
  
  <h1>Просмотр профиля</h1>
  <form class="fc">
  <fieldset>
	   <legend>Пользователь  {if $currentUser->getViewAs() == 1}{$currentUser->getNikname()|escape:"html"}{else}{$currentUser->firstname|escape:"html"}
               &#160;{$currentUser->lastname|escape:"html"}&#160;{$currentUser->middlename|escape:"html"}{/if}</legend>
		<!--<h1>{if $currentUser->view_as == 1}{$currentUser->nikname|escape:"html"}{else}{$currentUser->firstname|escape:"html"}
				{$currentUser->lastname|escape:"html"}{$currentUser->middlename|escape:"html"}{/if}</h1>-->
		{if $currentUser->id == $user->id}
			<a href="{$currentUser->getUserPath('avatars')}">{/if}
			<img src="{$currentUser->getAvatar()->getMedium()}" border="0" >
        {if $currentUser->id == $user->id}
            </a>
        {/if}

		{if $currentUser->isOnline()}
		  <br>Пользователь сейчас <span style="color: rgb(51, 153, 0);"><b>Online</b></span>
		{else}
		  <br>Последняя активность {$currentUser->getLastOnline()} назад
		{/if}
  </fieldset>

<fieldset>
<legend>Персональная информация</legend>
{*
	<label for="email" class="required">Email: </label>
		<span class="profile_view">{$currentUser->login|escape:"html"}</span><br>
		*}
	<label for="nikname" class="required">Ник: </label>
		<span class="profile_view">{$currentUser->nikname|escape:"html"}</span><br>
	{if $currentUser->lastname}
	<label for="firstname">Имя: </label>
		<span class="profile_view">{$currentUser->lastname|escape:"html"}</span><br>
	{/if}
	{if $currentUser->firstname}
	<label for="lastname">Фамилия: </label>
		<span class="profile_view">{$currentUser->firstname|escape:"html"}</span><br>
	{/if}
	{if $currentUser->middlename}
	<label for="lastname">Отчество: </label>
		<span class="profile_view">{$currentUser->middlename|escape:"html"}</span><br>
	{/if}
	<label for="sex" class="required">Пол: </label>
		<span class="profile_view">{if $currentUser->gender eq 'male'}
                                {t}Мужчина{/t}
                            {else}
                                {t}Женщина{/t}
                            {/if}</span><br>

{if !$currentUser->getBirthdayPrivate()}
	<label for="birthday" class="required">Дата рождения: </label>
	<span class="profile_view">{$birthday}</span><br>
{/if}
	<label for="country" class="required">Страна: </label>
		<span class="profile_view">{$currentUser->getCountry()->name|escape:"html"}</span><br>
	<label for="city" class="required">Город: </label>
		<span class="profile_view">{$currentUser->getCity()->name|escape:"html"}</span><br>
	{if $currentUser->getMetroId()}
	<label for="metro">Ст. метро: </label>
		<span class="profile_view">{$currentUser->getMetro()->name|escape:"html"}</span><br>
	{/if}
	{if $currentUser->street}
     <label>Адрес:</label>
       <span class="profile_view"> {$currentUser->street|escape:"html"} {$currentUser->build|escape:"html"} {$currentUser->apartment|escape:"html"} </span><br />
    {/if}
</fieldset>
    <fieldset>
        <legend class="required">О себе</legend>
        {if !$custom_bike}
        {if null !== $currentUser->getBikeId()}
            <label class="required">Я езжу на:</label> <span class="profile_view">
            {* <a href="/catalog/model/id/{$currentUser->getBikeId()}/"> *}
	{$currentUser->getBike()->getModel()->getTrademark()->getName()} {$currentUser->getBike()->getModel()->getName()} {$currentUser->getBike()->getYear()}
	{* </a> *} </span><br />
        {/if}
        {else}
            <label class="required">Я езжу на:</label><span class="profile_view">{$custom_bike}</span>
        {/if}
        {$currentUser->intro|escape:html}
    </fieldset>
    {if $currentUser->phone or $currentUser->icq or $currentUser->skype or $currentUser->livejournal or $currentUser->homepage or $currentUser->msn}
<fieldset>
<legend>Контактная информация</legend>
{*
	{if $currentUser->phone}
	<label for="phone">Телефон: </label>
		<span class="profile_view">
            {$currentUser->phone|escape:"html"}<br /></span><br>
    {/if}
*}
    {if $currentUser->icq}
	<label for="icq">ICQ: </label>
		<span class="profile_view">
		<a href='http://web.icq.com/whitepages/message_me/1,,,00.icq?uin={$currentUser->icq|escape:"html"}&action=message' onclick='window.open("http://web.icq.com/whitepages/message_me/1,,,00.icq?uin={$currentUser->icq|escape:"html"}&action=message"); return false;'><img src="http://web.icq.com/whitepages/online?icq={$currentUser->icq|escape:"html"}&img=5" align="absmiddle" />
            {$currentUser->icq|escape:"html"}</a></span><br>
     {/if}

	{if $currentUser->skype}
	  <label for="skype">Skype: </label>
		<span class="profile_view"><a href="callto:{$currentUser->skype|escape:"html"}"><img src="http://mystatus.skype.com/smallicon/{$currentUser->skype|escape:"html"}" align="absmiddle">
            {$currentUser->skype|escape:"html"}</a></span><br>
	{/if}

    {if $currentUser->livejournal}
	    <label for="livejournal">LiveJournal: </label>
		<span class="profile_view"><img src="http://stat.livejournal.com/img/userinfo.gif" align="absmiddle">
            {t}LiveJournal:{/t} {$currentUser->livejournal|escape:"html"}<br />
		</span><br>
    {/if}

    {if $currentUser->homepage}
	<label for="homepage">Домашняя страница: </label>
	  <span class="profile_view">
       <a href="http://{$currentUser->homepage|escape:"html"}" target="_blank">http://{$currentUser->homepage|escape:"html"}</a><br /></span><br>
    {/if}

      {if $currentUser->msn}
	    <label for="msn" >MSN: </label>
		  <span class="profile_view">
            {$currentUser->msn|escape:"html"}<br /></span>
     {/if}
   </fieldset>
 {/if}
 {if $currentUser->getProfit() != 0 or $currentUser->company or $currentUser->post or $currentUser->getUserUtilityes()}
 <fieldset>
   <legend>Дополнительная информация</legend>
	{if $currentUser->getProfit() != 0}
	<label for="profit">Сфера деятельности: </label>
		<span class="profile_view">{if $currentUser->getProfit()->name != ''}{$currentUser->getProfit()->name|escape:"html"} {else} {$currentUser->getProfit()->groupName|escape:"html"} {/if}<br /></span>
   <br>
    {/if}
   {if $currentUser->company}
      <label for="company">Компания:</label>
		<span class="profile_view">{$currentUser->company|escape:"html"}</span> <br>
   {/if}

   {if $currentUser->post}
	    <label for="post">Должность:</label>
		<span class="profile_view">{$currentUser->post|escape:"html"}</span><br>
	{/if}
	{if $currentUser->getUserUtilityes()}
    <table cellpadding="0" cellspacing="0" border="0">
		{foreach from=$currentUser->getUserUtilityes() item=utility name=util}
		  <tr><td>{if $smarty.foreach.util.first}<label for="useful">Дополнительно:</label>{else}&nbsp;{/if}</td>
			<td><input type="checkbox" name="checkbox" id="checkbox" checked disabled/> {$utility}</td>
		  </tr>
		{/foreach}
	</table>
	{/if}
  </fieldset>
  {/if}
  {*{if $currentUser->latitude > 0 && $currentUser->latitude != null}*}
  {*<fieldset>*}
  	 {*<legend>Место на карте</legend>*}
		{*{$google_map}*}
  {*</fieldset>*}
  {*{/if}*}
</form>

<a href="{$currentUser->getUserPath('edit')}" id="edit" {if $active=='edit' } class='active_link' {/if} >Редактировать профиль</a> |
<a href="{$currentUser->getUserPath('password')}" id="messages" {if $active=='password' } class='active_link' {/if}>Изменение пароля</a> |
