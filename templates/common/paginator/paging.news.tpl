{if $pgr.totalPages>1}
<div class="pages" >
 <input type="hidden" name="page_num" value="1" id="page_num">
  {if !empty($pgr.prevUrl)}
	 <a href="{$pgr.prevUrl}/" class="ahead_pg"> Пред. << </a>
	 &nbsp;&nbsp;&nbsp;
  {/if}

{if empty($pgr.current)} <{assign var="cur_page" value="1"}> {/if}

{foreach from=$pgr.urls key=url item=number}
  {if $pgr.current!=$number  && !empty($url)}
   <a href="{$url}/" class="ahead_pg">{$number}</a>
		{elseif $pgr.current==$number }
			&nbsp; <b >{$number}&nbsp;</b>
  {/if}
{/foreach}
&nbsp;&nbsp;&nbsp;
 {if $pgr.nextUrl!=$pgr.lastUrl && !empty ($pgr.totalPages) && $pgr.totalPages!=1 }
	<a href="{$pgr.nextUrl}/" class="ahead_pg"> >> След.</a>
	&nbsp;&nbsp;&nbsp;
 {/if}
</div> 
{/if}