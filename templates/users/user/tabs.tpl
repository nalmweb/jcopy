Кабинет пользователя
<div>
  <a href="/users/ads"  {if $active=='ads' } class='active_link' {/if} >Мои обьявления</a>
  <a href="{$currentUser->getUserPath('profile')}" id="profile"  >Мой
    профиль</a>
  <a href="/users/logout/">Выход</a>
</div>
<br/>