<h1 style="margin-bottom: -5px;"><a href="/">{$crumbs[0]}</a> / <a href="/board/">{$crumbs[1]}</a> / <a
  href="/board/listauto/">Легковые автомобили</a>{if !empty($trademark_name)} / <a
  href="/board/listauto/trademark/{$trademark_name}">{$trademark_name}</a>{/if}
{if !empty($model_name)} / <a
  href="/board/listauto/trademark/{$trademark_name}/model/{$model_name}">{$model_name}</a>{/if}
</h1>
<a href="/board/addauto" style="color: green;">продать</a>

<br/><br/>

{if !empty($trademarks)}
{include file="board/board.trademarks.list.tpl"}
{/if}

{include file="board/board.models.list.tpl" }
{include file="board/board.search.bikes.tpl"}
{include file="common/paginator/paging.tpl" }

<br/>
<table class="table_catalog" cellspacing="0" border="0">
  <tr>
    <th scope="col" class="nobg">{if !empty($tm)}<img src="{$tm->getLogo()->getDataPath()}" alt="{$tm->getName()}">{/if}
    </th>
    <th scope="col">модель</th>
    <th scope="col">год выпуска</th>
    <th scope="col">тип</th>
    <th scope="col">цена</th>
    <th scope="col">город</th>
    <th scope="col">дата размещения</th>
  </tr>
{foreach from=$bikeList item=item}
  <tr>
    <th scope="row" class="photo">
      {if !empty($item->imageList)}<a href="/board/item/auto/{$item->getId()}.html"><img
        src="http://{$BASE_HTTP_HOST}{$item->imageList[0].small}" alt=""></a>{/if}
    </th>
    <td><br/>
      <nobr>{$item->getModel()}</nobr>
      <br><a href="/board/item/auto/{$item->getId()}.html">{$item->getTitle()}</a></td>
    <td>{$item->getYear()}</td>
    <td>{$item->getBikeType()}</td>
    <td>
      <nobr>{$item->getPrice()|default:"-"}p</nobr>
    </td>
    <td>{$item->getCity()->name}({$item->getCity()->getCountry()->name|escape:html})</td>
    <td nowrap>{$item->reg_date|date_format:"%d.%m.%Y"}</td>
  </tr>
{/foreach}
</table>