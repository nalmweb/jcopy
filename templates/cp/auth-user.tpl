<div class="auth-usr">
  <div class="inner"><i>кабинет администратор</i>
    <div class="auth-right"></div>
    <a class="i_usr" href="/users/profile/userid/{$user->getId()}/">{$user->nikname}</a>

    {if $AdminID == 2}
      <img class="link_tr" src="/images/admin/link_tr.jpg" alt=""/>
      <a class="i_log" href="http://{$BASE_HTTP_HOST}/admin">Кабинет суперадминистратора</a>
    {/if}

    <img class="link_tr" src="/images/admin/link_tr.jpg" alt=""/>
    <a class="i_log" href="http://{$BASE_HTTP_HOST}/users/logout/">Выйти</a>
  </div>
</div>