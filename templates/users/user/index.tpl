

{literal}
<style>
  .inactive, .inactive a
  {
    color:#a9a9a9;
  }
</style>
{/literal}


<table>
  <tr><td>Легковые автомобили:</td></tr>
  <tr><td>
    <table width="100%" border="1" style="border-style: solid; border-width: 1px; border-color: #c7d9d6;">
      <tr style="background-color: #33445a; color: white; text-align: center;">
        <td width="25px">Фото</td>
        <td width="">Заголовок</td>
        <td width="60px">Цена</td>
        <td>Дата подачи</td>
        <td>Дата окончания</td>
        <td colspan="3" width="20%">Операции</td>
      </tr>

    {foreach from=$bikeList item=ad}
      <tr  {if !$ad->getIsActive() } class="inactive" {/if}  id="{$ad->getCatId()}_{$ad->getId()}" >
        <td>{if $ad->hasImages()!=0}<center><img src="/images/photo.gif"></center>{/if}</td>
        <td><a href="/board/item/auto/{$ad->getId()}.html">{$ad->title}</a></td>
        <td><center>{$ad->getPrice()}</center></td>
        <td>{$ad->getRegDate()|date_format:"%m.%d.%Y"}</td>
        <td>{$ad->getEndDate()|date_format:"%m.%d.%Y"}</td>
        {assign var=catId value=$ad->getCatId()}
        {assign var=itemId value=$ad->getId()  }

        <td>
          {if $ad->getIsActive()}
          <div id="btn_{$catId}_{$itemId}">
            {linkbutton name="Деактивировать" onclick="xajax_changeAdStatus( $catId, $itemId,1 )" }
		{else}
			{linkbutton name="Активировать" onclick="xajax_changeAdStatus( $catId, $itemId,0 )"}
		{/if}
        </div>
        </td>
      {*<td><a href="/users/adsEdit/cat/{$catId}/item/{$itemId}/">Изменить</a> </td>*}
        <td><a href="/users/adsDelete/cat/{$catId}/item/{$itemId}/">Удалить</a> </td>
      </tr>
    {/foreach}
    </table>
  </td>
  </tr>
</table>