{*if $currentUser->id == $user->id}
  <div>
        //<a href="/admin/utility/">Полезность</a>&#160;|&#160;
        <a href="/admin/countries/">Страны</a>&#160;|&#160;
        <a href="/admin/cities/">Города</a>&#160;|&#160;
        <a href="/admin/catalog/">Каталог</a>&#160;|&#160;
 		<a href="/admin/board/">Объявления</a>&#160;|&#160;

 		//<a href="/admin/mail/">Рассылки</a>

 		//<a href="/admin/mailtemplates/">Шаблоны писем</a>
 		//<a href="/admin/massmail/">Отправка писем.</a>
 		//<a href="/admin/mailarchive/">Архив рассылки.</a>
    </div>
    <div class='clear' style="padding:10px;"><span /></div>
{/if*}


  <div id="Menu">
    <div id="TopMenu">
      <ul>
        <li id='tab0' {if $menuTab == '' or !isset($menuTab)}class='active'{/if}>Общее<span></span></li>
        <li id='tab1' {if $menuTab == 'autohaus'}class='active'{/if}>Автахаусы<span></span></li>
        <li id='tab2' {if $menuTab == 'users'}class='active'{/if}>Пользователи<span></span></li>
        <li id='tab3' {if $menuTab == 'board'}class='active'{/if}>Обьявления<span></span></li>
        <li id='tab4' {if $menuTab == 'advertising'}class='active'{/if}>Реклама<span></span></li>
      </ul>
    </div>
    <div id="BottomMenu">
      <ul class='tab0'>
        <li><a {if $menuPodTab == ''}class='active'{/if} href="/cp/">Общее</a></li>
      </ul>
      <ul class='tab1'>
        <li><a {if $menuPodTab == '1'}class='active'{/if} href="/cp/">Автахаусы</a></li>
      </ul>
      <ul class='tab2'>
        <li><a {if $menuPodTab == 'users'}class='active'{/if} href="/cp/users">Пользователи</a></li>
      </ul>
      <ul class='tab3'>
        <li><a {if $menuPodTab == 'board'}class='active'{/if} href="/cp/board">Обьявления</a></li>
        <li><a {if $menuPodTab == 'cars'}class='active'{/if} href="/cp/boardCars/">Легковые</a></li>
      </ul>
      <ul class='tab4'>
        <li><a {if $menuPodTab == '4'}class='active'{/if} href="/cp/">Реклама</a></li>
      </ul>
    </div>
  </div>
