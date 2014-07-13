<h2 class="orange">Управление пользователями</h2>
<p>Здесь вы можете добовлять или изменять данные пользователей</p>
<br/>

{include file="admin/errors.tpl"}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div id="ajaxContent" style="display:none">{$ajaxContent}</div>
    <table class="sTable">
      <tr class="first">
        <td class="tleft">id</td>
        <td class="tleft">Ник</td>
        <td class="tleft">Фамилия</td>
        <td class="tleft">Имя</td>
        <td class="tleft">Отчество</td>
        <td class="tleft">Email</td>
        <td class="tleft">Дата регистрации</td>
        <td>Параметры</td>
      </tr>
    {foreach from=$users_array key=key item=user}
      <tr>
        <td width="40" class="tleft">
          {$user->id}
        </td>
        <td class="tleft">
          {$user->nikname}
        </td>
        <td class="tleft">
          {$user->firstname}
        </td>
        <td class="tleft">
          {$user->lastname}
        </td>
        <td class="tleft">
          {$user->middlename}
        </td>
        <td class="tleft">
          {$user->login}
        </td>
        <td class="tleft">
          {$user->registerDate}
        </td>
        <td width="40" class="tleft">

        </td>
      </tr>
    {/foreach}
    </table>
  </div>
</div>

{include file="paginator.tpl"}