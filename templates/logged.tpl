<div id="user" style="float:right;padding: 7px; position: absolute; right: 0; background-color: #FFF">
		<div style="float:left;"><img id="user_icon" src="{$user->getAvatar()->getSmall()}"></div>
		<div id="text" style="float:left;padding-left:3px;">
			Привет, {$user->nikname}<br />
			{*<a href="http://{$BASE_HTTP_HOST}/users/profile/userid/{$user->id}/">Кабинет</a> | <a href="/users/messagelist/">*}
			<a href="http://{$BASE_HTTP_HOST}/users/">Кабинет</a> |
			{*<a style="color: red;" href="http://{$BASE_HTTP_HOST}/feedback/">Нашел ошибку?</a> | *}<a href="http://{$BASE_HTTP_HOST}/users/logout/">Выход </a>
		</div>		
</div>
<div id="clear"></div>