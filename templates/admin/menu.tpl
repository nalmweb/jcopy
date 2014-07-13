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
              <li id='tab1' {if $menuTab == 'board'}class='active'{/if}>Обявления<span></span></li>
              <li id='tab2' {if $menuTab == 'catalog'}class='active'{/if}>Соответствия<span></span></li>
              <li id='tab3' {if $menuTab == '1'}class='active'{/if}>Партнерка<span></span></li>
              <li id='tab4' {if $menuTab == 'partner'}class='active'{/if}>Каталоги<span></span></li>
              <li id='tab5' {if $menuTab == '1'}class='active'{/if}>Информация<span></span></li>
              <li id='tab6' {if $menuTab == 'settings'}class='active'{/if}>Настройки<span></span></li>
          </ul>
      </div>
      <div id="BottomMenu">
          <ul class='tab0'>
              <li><a {if $menuPodTab == ''}class='active'{/if} href="/admin/">Общее</a></li>
              <li><a {if $menuPodTab == 'country'}class='active'{/if} href="/admin/countries/">Страны</a></li>
              <li><a {if $menuPodTab == 'city'}class='active'{/if} href="/admin/cities/">Города</a></li>
              <li><a {if $menuPodTab == '12'}class='active'{/if} href="#">Валюты</a></li>
              <li><a {if $menuPodTab == '121'}class='active'{/if} href="#">Роли</a></li>
              <li><a {if $menuPodTab == '121i'}class='active'{/if} href="#">Пеня</a></li>
          </ul>
          <ul class='tab1'>
              <li><a {if $menuPodTab == 'board'}class='active'{/if} href="/admin/board/">Обьявления</a></li>
              <li><a {if $menuPodTab == 'options'}class='active'{/if} href="/admin/boardoptions/">Опции</a></li>
              <li><a {if $menuPodTab == 'price'}class='active'{/if} href="/admin/boardprice/">Цены</a></li>
          </ul>
          <ul class='tab2'>
              <li><a {if $menuPodTab == 'catalog'}class='active'{/if} href="/admin/catalog/">Соответствия</a></li>
              <li><a {if $menuPodTab == 'trademarks'}class='active'{/if} href="/admin/trademarks/">Производители</a></li>
              <li><a {if $menuPodTab == 'models'}class='active'{/if} href="/admin/models/">Модели</a></li>
              <li><a {if $menuPodTab == 'modification'}class='active'{/if} href="/admin/modification/">Модификации</a></li>
              <li><a {if $menuPodTab == 'years'}class='active'{/if} href="/admin/years/">Года</a></li>
              <li><a {if $menuPodTab == 'propertiesS'}class='active'{/if} href="/admin/catalogPropertiesSettings/">Параметры</a></li>
              <li><a {if $menuPodTab == 'setPropModels'}class='active'{/if} href="/admin/setPropModels/">Связи по модели</a></li>
              <li><a {if $menuPodTab == 'setPropModification'}class='active'{/if} href="/admin/setPropModification/">Связи по модификации</a></li>
              <li><a {if $menuPodTab == 'setPropYears'}class='active'{/if} href="/admin/setPropYears/">Связи по годам</a></li>
          </ul>
          <ul class='tab3'>
            <li><a {if $menuPodTab == 'settings3'}class='active'{/if} href="#">Партнерка</a></li>
            <li><a {if $menuPodTab == 'settings31'}class='active'{/if} href="#">Добавить партнера</a></li>
            <li><a {if $menuPodTab == 'settings32'}class='active'{/if} href="#">Список партнеров</a></li>
            <li><a {if $menuPodTab == 'settings33'}class='active'{/if} href="#">Настройка уровня и процентов</a></li>
            <li><a {if $menuPodTab == 'settings34'}class='active'{/if} href="#">Транзакции</a></li>
            <li><a {if $menuPodTab == 'settings35'}class='active'{/if} href="#">Выплаты</a></li>
          </ul>
          <ul class='tab4'>
            <li><a {if $menuPodTab == 'partner'}class='active'{/if} href="/admin/partner/">Каталоги</a></li>
            <li><a {if $menuPodTab == 'partnerlist'}class='active'{/if} href="/admin/partnerList/">Список</a></li>
            <li><a {if $menuPodTab == 'partneradd'}class='active'{/if} href="/admin/partnerAdd/">Добавить</a></li>
          </ul>
          <ul class='tab5'>
            <li><a {if $menuPodTab == 'settings5'}class='active'{/if} href="#">Информация</a></li>
            <li><a {if $menuPodTab == 'settings6'}class='active'{/if} href="#">FAQ</a></li>
          </ul>
          <ul class='tab6'>
              <li><a {if $menuPodTab == 'settings'}class='active'{/if} href="#">Настройки</a></li>
          </ul>
      </div>
  </div>
