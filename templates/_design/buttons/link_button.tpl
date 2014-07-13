{strip}
{if $params.link}
<a class="button" href="{$params.link}" {if $params.onclick}onclick="{$params.onclick}" {/if} {if $params.id} id="{$params.id}" {/if} > <span>{$params.name}</span></a>
{else}
<a class="button" href="#null" {if $params.onclick}onclick="{$params.onclick}"{/if} {if $params.id} id="{$params.id}" {/if}>
<span>{$params.name}</span></a>
{/if}
{/strip}