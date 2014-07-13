{if $pgr.totalPages>1}
<div class="pages">
 <input type="hidden" name="page_num" value="1" id="page_num">
 
{if !empty($pgr.firstUrl)}
 <a href="#" class="ahead_pg"  
   {if $pgr.firstUrlNum} onclick="sp({$pgr.firstUrlNum})" {/if} >Первая</a>&nbsp;&nbsp;&nbsp;
{/if}

{if !empty($pgr.prevUrl)}
	<a href="#" class="ahead_pg" 
	 {if $pgr.prevUrlNum} onclick="sp({$pgr.prevUrlNum})" {/if} > Пред. << </a>&nbsp;&nbsp;&nbsp;
{/if}

{if empty($pgr.current)}
	<{assign var="cur_page" value="1"}>
{/if}

{foreach from=$pgr.urls key=url item=number}
  {if $pgr.current!=$number  && !empty($url)}
    <a href="#" class="ahead_pg" onclick="sp({$number})">{$number}</a>
  {elseif $pgr.current==$number }
	 &nbsp;<b>{$number}&nbsp;</b>
  {/if}
{/foreach}
&nbsp;&nbsp;&nbsp;
{if $pgr.nextUrl!=$pgr.lastUrl && !empty ($pgr.totalPages) && $pgr.totalPages!=1 }
 <a href="#" class="ahead_pg" {if $pgr.nextUrlNum} onclick="sp({$pgr.nextUrlNum})"{/if} >След.</a>
 &nbsp;&nbsp;&nbsp;
{/if}

{if !empty ($pgr.totalPages) && $pgr.totalPages!=1}
   <a href="#" class="ahead_pg" {if $pgr.lastUrlNum} onclick="sp({$pgr.lastUrlNum})"{/if}>Последняя</a>
{/if}
</div>
 {/if}

