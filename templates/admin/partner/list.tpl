<h1 class="orange">Список каталогов</h1>
<p>Здесь вы можете посмотреть весь список каталогов(партнеров) в системе</p>
<br>

{include file="admin/errors.tpl"}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div id="ajaxContent" style="display:none">{$ajaxContent}</div>
    <table class="sTable">
      <tr class="first">
        <td class="tleft">id</td>
        <td class="tleft">Название</td>
        <td class="tleft">Страна</td>
        {*<td class="tleft">Город</td>*}
        <td class="tleft">Сайт</td>
        <td class="tleft">Ключь доступа</td>
        <td class="tleft">Уникальных</td>
        <td class="tleft">Цена</td>
        <td class="tleft">Пеня</td>
        <td class="tleft">Дата изменения</td>
        <td>Параметры</td>
      </tr>
    {foreach from=$partner key=number item=item}
      <tr>
        <td width="10" class="tleft">
          {$item->getId()}
        </td>
        <td class="tleft">
          {$item->getName()}
        </td>
        <td>
          {$item->getCountry()->getName()}
        </td>
        {*<td>*}
          {*{$item->getCity()->getName()}*}
        {*</td>*}
        <td width="40">
          {if $item->getSiteUrl()}
            <a href="{$item->getSiteUrl()}">{$item->getSiteUrl()}</a>
          {else}
            <i>неуказан</i>
          {/if}
        </td>
        <td width="40">
          {$item->getPasswordKey()}
        </td>
        <td width="40">
          {$item->getUnique()}
        </td>
        <td width="40">
          {$item->getPrice()}
        </td>
        <td width="40">
          {$item->getPenalty()}
        </td>
        <td>
          {$item->getUpdateTime()}
        </td>
        <td width="40">
          <a href="/admin/partnerAdd/?param=edit&id={$item->getId()}" title="Редактировать"><img src="{$icon_page}/pen_alt_fill_16x16.png"></a>
          <a href="/admin/partnerDelete/?id={$item->getId()}" title="Удалить"><img src="{$icon_page}/trash_fill_16x16.png"></a>
        </td>
      </tr>
    {/foreach}
    </table>
  </div>
</div>

{include file="paginator.tpl"}

