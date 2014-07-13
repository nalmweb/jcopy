    <br>
		<br />
		<form {$formContent.attributes}>
		{$formContent.hidden}
		<strong>Ник:</strong> {$formContent.nikname.html} {$formContent.strict_nikname.html} <br />

		<strong>Пол:</strong> {$formContent.gender.html}<br />

		<strong>Страна:</strong> {$formContent.country.html} {$formContent.strict_country.html}<br />
		<strong>Город:</strong> {$formContent.city.html}{$formContent.strict_city.html}<br />
		<strong>Улица:</strong> {$formContent.street.html}{$formContent.strict_street.html}<br>
		<strong>Ст. метро:</strong> {$formContent.metro.html} {$formContent.strict_metro.html}<br />

		{$formContent.submitForm.html}
		</form>

		{if $searchResult}
		{if $pagging}{$pagging}{/if}
		<table cellpadding="2" cellspacing="0" border="1">
        <tr>
		    <th>НИК</th>
            <th>ПОЛ</th>
            <th>СТРАНА</th>
            <th>ГОРОД</th>
            <th>УЛИЦА</th>
            <th>СТАНЦИЯ МЕТРО</th>
        </tr>
        {foreach key=key from=$searchResult item=person}
        <tr>
            <td><a href="/users/profile/userid/{$person.id}/">{$person.nikname}</a></td>
            <td>{if $person.gender == 'male'}Мужчина{elseif $person.gender == 'female'}Женщина{else}Не известно{/if}</td>
            <td>{$person.country}</td>
            <td>{$person.city}</td>
            <td>{$person.street}</td>
            <td>{$person.metro}</td>
        </tr>
        {/foreach}
		</table>
		{/if}
		{if $noResult}
		<br>Поиск не дал результатов. Попробуйте еще.
		{/if}