{if $pgr && $pgr.totalPages > 1}
<div id="navigated">
  <ul>
    {foreach from=$pgr.urls key=uri item=number}
      {if $number == $pgr.current}
        <li class="active">{$number}</li>
      {else}
        <li><a href="{$uri}">{$number}</a></li>
      {/if}
    {/foreach}
  </ul>
</div>
{/if}