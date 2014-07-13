<?php /* Smarty version 2.6.16, created on 2014-07-12 16:46:43
         compiled from admin/menu.tpl */ ?>


  <div id="Menu">
      <div id="TopMenu">
          <ul>
              <li id='tab0' <?php if ($this->_tpl_vars['menuTab'] == '' || ! isset ( $this->_tpl_vars['menuTab'] )): ?>class='active'<?php endif; ?>>Общее<span></span></li>
              <li id='tab1' <?php if ($this->_tpl_vars['menuTab'] == 'board'): ?>class='active'<?php endif; ?>>Обявления<span></span></li>
              <li id='tab2' <?php if ($this->_tpl_vars['menuTab'] == 'catalog'): ?>class='active'<?php endif; ?>>Соответствия<span></span></li>
              <li id='tab3' <?php if ($this->_tpl_vars['menuTab'] == '1'): ?>class='active'<?php endif; ?>>Партнерка<span></span></li>
              <li id='tab4' <?php if ($this->_tpl_vars['menuTab'] == 'partner'): ?>class='active'<?php endif; ?>>Каталоги<span></span></li>
              <li id='tab5' <?php if ($this->_tpl_vars['menuTab'] == '1'): ?>class='active'<?php endif; ?>>Информация<span></span></li>
              <li id='tab6' <?php if ($this->_tpl_vars['menuTab'] == 'settings'): ?>class='active'<?php endif; ?>>Настройки<span></span></li>
          </ul>
      </div>
      <div id="BottomMenu">
          <ul class='tab0'>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == ''): ?>class='active'<?php endif; ?> href="/admin/">Общее</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'country'): ?>class='active'<?php endif; ?> href="/admin/countries/">Страны</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'city'): ?>class='active'<?php endif; ?> href="/admin/cities/">Города</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == '12'): ?>class='active'<?php endif; ?> href="#">Валюты</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == '121'): ?>class='active'<?php endif; ?> href="#">Роли</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == '121i'): ?>class='active'<?php endif; ?> href="#">Пеня</a></li>
          </ul>
          <ul class='tab1'>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'board'): ?>class='active'<?php endif; ?> href="/admin/board/">Обьявления</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'options'): ?>class='active'<?php endif; ?> href="/admin/boardoptions/">Опции</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'price'): ?>class='active'<?php endif; ?> href="/admin/boardprice/">Цены</a></li>
          </ul>
          <ul class='tab2'>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'catalog'): ?>class='active'<?php endif; ?> href="/admin/catalog/">Соответствия</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'trademarks'): ?>class='active'<?php endif; ?> href="/admin/trademarks/">Производители</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'models'): ?>class='active'<?php endif; ?> href="/admin/models/">Модели</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'modification'): ?>class='active'<?php endif; ?> href="/admin/modification/">Модификации</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'years'): ?>class='active'<?php endif; ?> href="/admin/years/">Года</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'propertiesS'): ?>class='active'<?php endif; ?> href="/admin/catalogPropertiesSettings/">Параметры</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'setPropModels'): ?>class='active'<?php endif; ?> href="/admin/setPropModels/">Связи по модели</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'setPropModification'): ?>class='active'<?php endif; ?> href="/admin/setPropModification/">Связи по модификации</a></li>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'setPropYears'): ?>class='active'<?php endif; ?> href="/admin/setPropYears/">Связи по годам</a></li>
          </ul>
          <ul class='tab3'>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings3'): ?>class='active'<?php endif; ?> href="#">Партнерка</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings31'): ?>class='active'<?php endif; ?> href="#">Добавить партнера</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings32'): ?>class='active'<?php endif; ?> href="#">Список партнеров</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings33'): ?>class='active'<?php endif; ?> href="#">Настройка уровня и процентов</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings34'): ?>class='active'<?php endif; ?> href="#">Транзакции</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings35'): ?>class='active'<?php endif; ?> href="#">Выплаты</a></li>
          </ul>
          <ul class='tab4'>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'partner'): ?>class='active'<?php endif; ?> href="/admin/partner/">Каталоги</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'partnerlist'): ?>class='active'<?php endif; ?> href="/admin/partnerList/">Список</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'partneradd'): ?>class='active'<?php endif; ?> href="/admin/partnerAdd/">Добавить</a></li>
          </ul>
          <ul class='tab5'>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings5'): ?>class='active'<?php endif; ?> href="#">Информация</a></li>
            <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings6'): ?>class='active'<?php endif; ?> href="#">FAQ</a></li>
          </ul>
          <ul class='tab6'>
              <li><a <?php if ($this->_tpl_vars['menuPodTab'] == 'settings'): ?>class='active'<?php endif; ?> href="#">Настройки</a></li>
          </ul>
      </div>
  </div>