<h2 class="orange">Легковые автомобили</h2>
<br/>

{include file="admin/errors.tpl"}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div id="ajaxContent" style="display:none">{$ajaxContent}</div>
    <table class="sTable">
      <tr class="first">
        <td class="tleft">id</td>
        <td class="tleft">Марка</td>
        <td class="tleft">Модель</td>
        <td class="tleft">Модификация</td>
        <td class="tleft">Год</td>
        <td class="tleft">Цена</td>
        <td class="tleft">Дата начала</td>
        <td class="tleft">Дата конца</td>
        <td>Параметры</td>
      </tr>
    {foreach from=$cars_array key=key item=user}
      <tr>
        <td width="40" class="tleft">
          {$user->id}
        </td>
        <td class="tleft">
          {$user->getMark()}
        </td>
        <td class="tleft">
          {$user->getModel()}
        </td>
        <td class="tleft">
          {*{$user->lastname}*}
        </td>
        <td class="tleft">
          {$user->getYear()}
        </td>
        <td class="tleft">
          {$user->getPrice()}
        </td>
        <td class="tleft">
          {$user->getRegDate()}
        </td>
        <td class="tleft">
          {$user->getEndDate()}
        </td>
        <td width="40" class="tleft">

        </td>
      </tr>
    {/foreach}
    </table>
  </div>
</div>

{include file="paginator.tpl"}