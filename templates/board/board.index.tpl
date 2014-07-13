{$breadcrumbs}
<!--<div class="b_block"></div>
<div class="b_block"></div>
<div class="b_block"></div>-->
<table width="100%" border="0">

  <tr>
    <td width="33%"><h1 style="margin-bottom: -5px;">Продается</h1><a href="/board/addauto/" style="color: green;">продать</a>
  </tr>

  <tr>
    <td>
    {foreach from=$bikeMarks item=item key=key}
      <a href="/board/listauto/trademark/{$item}/">{$item}</a>&nbsp;
    {/foreach}<br>
    </td>
  </tr>

  <tr>
    <td>
      <table width="100%" border="1" style="border-style: solid; border-width: 1px; border-color: #c7d9d6;">
        <tr style="background-color: #33445a; color: white; text-align: center;">
          <td width="25px">Фото</td>
          <td width="">Модель</td>
          <td width="60px">Цена</td>
        </tr>
      {foreach from=$bikeList item=ad}
        <tr>
          <td>{if $ad->hasImages()!=0}
            <center><img src="/images/photo.gif"></center>{/if}</td>
          <td><a href="/board/item/auto/{$ad->getId()}.html">{$ad->title}</a></td>
          <td>
            <center>{$ad->getPrice()}</center>
          </td>
        </tr>
      {/foreach}
      </table>
      <a href="/board/listauto/">Смотреть все</a>
    </td>
  </tr>
</table>


<div style="height:300px;"></div>
<div id="clear"></div>