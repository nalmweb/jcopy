
{if $is_autohouse}
  {include file="users/autohause/tabs.tpl" active="edit"}
  {include file="users/autohause/index.tpl"}
{else}
  {include file="users/user/tabs.tpl" active="edit"}
  {include file="users/user/index.tpl"}
{/if}