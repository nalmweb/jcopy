{literal}
<style type="text/css" media="all">
.table_catalog {
	width: 700px;
	padding: 0;
	margin: 0;
}
.table_catalog th {
	color: white;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
	border-top: 1px solid #C1DAD7;
	text-align: center;
	padding: 6px 6px 6px 12px;
	background: #354f6d url(/images/bg_header.jpg) no-repeat;
}
.table_catalog th.nobg {
	border-top: 0;
	border-left: 0;
	border-right: 1px solid #C1DAD7;
	background: none;
}
.table_catalog td {
	text-align: center;
	padding: 10px;
	border-right: 1px solid #C1DAD7;
	border-bottom: 1px solid #C1DAD7;
}
.table_catalog th.photo {
	padding: 5px;
	color: #333333;
	border-left: 1px solid #C1DAD7;
	border-top: 0;
	background: #fff;
}
</style>
{/literal}
<h1><a href="/">{$crumbs[0]}</a>/<a href="/board/">{$crumbs[1]}</a>/<a href="/board/listauto/">Легковые автомобили</a>{if !empty($trademark_name)}/<a href="/board/listauto/trademark/{$trademark_name}">{$trademark_name}</a>{/if}
{if !empty($model_name)}/<a href="/board/listauto/trademark/{$trademark_name}/model/{$model_name}">{$model_name}</a>{/if}
<br />

{if !empty($trademarks)}
 {include file="board/board.trademarks.list.tpl"}
{/if}

{include file="board/board.models.list.tpl" }
{include file="board/board.search.bikes.tpl"}
{include file="common/paginator/paging.tpl" }
<br />
<br />
<table class="table_catalog" cellspacing="0">
 <tr>
   <th scope="col" class="nobg">{if !empty($tm)}<img src="{$tm->getLogo()->getDataPath()}" alt="{$tm->getName()}">{/if}</th>
   <th scope="col">модель</th>
   <th scope="col">год выпуска</th>
   <th scope="col">тип</th>
   <th scope="col">цена</th>
   <th scope="col">город</th>
   <th scope="col">дата размещения</th>
 </tr>
  {foreach from=$bikeList item=item}
  <tr>

    <th scope="row" class="photo"><a href="/board/item/auto/{$item->getId()}.html"><img src="http://{$BASE_HTTP_HOST}{$item->imageList[0].small}" alt=""></a></th>
    <td><br /><nobr>{$item->getModel()}</nobr> 
    <br><a href="/board/item/auto/{$item->getId()}.html">{$item->getTitle()}</a></td>
    <td>{$item->getYear()}</td>
    <td>{$item->getType()}</td>
    <td><nobr>{$item->getPrice()|default:"-"}p</nobr></td>
    <td>{$item->getCity()->name}({$item->getCity()->getCountry()->name|escape:html})</td>
    <td nowrap>{$item->reg_date|date_format:"%d.%m.%Y"}</td>
  </tr>
  {/foreach}
</table>