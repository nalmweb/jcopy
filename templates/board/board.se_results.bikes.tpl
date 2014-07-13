<!-- SE BIKES -->
{literal}
<script language="javascript" >
function sp(page_number) 
{
  if(document.forms["h_search"])
  { 
//     alert("search");
		var frm = document.forms["h_search"]; 
		frm['page'].value = page_number; 
		frm.target = "_self"; 
//		frm.action = "/board/searchbikes/page/"+page_number+"/"; 
		frm.action = ""; 
		frm.submit(); 
//		return true;
  }
  return false;
}
</script>
{/literal}  
<h1><a href="/">{$crumbs[0]}</a> / <a href="/board/">{$crumbs[1]}</a> / <a href="/board/listauto/">Легковые автомобили</a>{if !empty($trademark_name)} / <a href="/board/listauto/trademark/{$trademark_name}">{$trademark_name}</a>{/if}
{if !empty($model_name)} / <a href="/board/listauto/trademark/{$trademark_name}/model/{$model_name}">{$model_name}</a>{/if}
<br />

{if !empty($trademarks)}
 {include file="board/board.trademarks.list.tpl"}
{/if}

{include file="board/board.search.bikes.tpl"}
<!-- paging must be different -> set onlick! -->
{include file="common/paginator/search_paging.tpl" }
<br />
<table class="table_catalog" cellspacing="0" border="1">
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
    <td>{$item->getBikeType()}</td>
    <td><nobr>{$item->getPrice()|default:"-"}p</nobr></td>
    <td>{$item->getCity()->name}({$item->getCity()->getCountry()->name|escape:html})</td>
    <td nowrap>{$item->reg_date|date_format:"%d.%m.%Y"}</td>
  </tr>
  {/foreach}
</table>

<form  name="h_search" action="/board/searchauto/" method="POST">

<input type="hidden" name="markId"   value="{$frm.markId}"/>
<input type="hidden" name="modelId"  value="{$frm.modelId}"/>
<input type="hidden" name="typeId"   value="{$frm.typeId}"/>

<input type="hidden" name="price[from]"  value="{$frm.price.from}"  maxlength="7"/>
<input type="hidden" name="price[to]"    value="{$frm.price.to}"  maxlength="7"/>

<input type="hidden" name="probeg[from]" value="{$frm.probeg.from}"  maxlength="7"/>
<input type="hidden" name="probeg[to]"   value="{$frm.probeg.to}"  maxlength="7"/>

<input type="hidden" name="year[from]" value="{$frm.year.from}"/>
<input type="hidden" name="year[to]" value="{$frm.year.to}"/>
<input type="hidden" name="is_photo" value="{$frm.is_photo}"/>

<input type="hidden" name="page" value=""/>
</form>