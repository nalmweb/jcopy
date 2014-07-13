<div>
{tab}
	{if $USE_USER_PATH}
		{if $ACTION_NAME eq 'viewtpl' || $ACTION_NAME eq ''}
			{tabitem link="`$use_user_path`/viewtpl/" active="1"}Шаблоны{/tabitem}
		{else}
			{tabitem link="`$use_user_path`/viewtpl/" active="0"}Шаблоны{/tabitem}
		{/if}
		
		
		
		{if $ACTION_NAME eq 'addtpl' || $ACTION_NAME eq ''}
			{tabitem link="`$use_user_path`/addtpl/" active="1"}Add Template{/tabitem}
		{else}
			{tabitem link="`$use_user_path`/addtpl/" active="0"}Add Template{/tabitem}
		{/if}
		
		
		
		{if $ACTION_NAME eq 'viewmess' || $ACTION_NAME eq ''}
			{tabitem link="`$use_user_path`/viewmess/" active="1"}Messages{/tabitem}
		{else}
			{tabitem link="`$use_user_path`/viewmess/" active="0"}Messages{/tabitem}
		{/if}
	
	
		{if $ACTION_NAME eq 'addmess' || $ACTION_NAME eq ''}
			{tabitem link="`$use_user_path`/addmess/" active="1"}Add Message{/tabitem}
		{else}
			{tabitem link="`$use_user_path`/addmess/" active="0"}Add Message{/tabitem}
		{/if}
		
		
		{if $ACTION_NAME eq 'settings' || $ACTION_NAME eq ''}
			{tabitem link="`$use_user_path`/settings/" active="1"}Settings{/tabitem}
		{else}
			{tabitem link="`$use_user_path`/settings/" active="0"}Settings{/tabitem}
		{/if}
	
	{else}
		{if $ACTION_NAME eq 'viewtpl' || $ACTION_NAME eq ''}
			{tabitem link="/`$MOD_NAME`/viewtpl/" active="0"}Templates{/tabitem}
		{else}
			{tabitem link="/`$MOD_NAME`/viewtpl/" active="0"}Templates{/tabitem}
		{/if}
		
		
		
		{if $ACTION_NAME eq 'addtpl' || $ACTION_NAME eq ''}
			{tabitem link="/`$MOD_NAME`/addtpl/" active="0"}Add Template{/tabitem}
		{else}
			{tabitem link="/`$MOD_NAME`/addtpl/" active="0"}Add Template{/tabitem}
		{/if}
		
		
		
		{if $ACTION_NAME eq 'viewmess' || $ACTION_NAME eq ''}
			{tabitem link="/`$MOD_NAME`/viewmess/" active="1"}Messages{/tabitem}
		{else}
			{tabitem link="/`$MOD_NAME`/viewmess/" active="0"}Messages{/tabitem}
		{/if}
		
		
		{if $ACTION_NAME eq 'addmess' || $ACTION_NAME eq ''}
			{tabitem link="/`$MOD_NAME`/addmess/" active="0"}Add Message{/tabitem}
		{else}
			{tabitem link="/`$MOD_NAME`/addmess/" active="0"}Add Message{/tabitem}
		{/if}
		


		{if $ACTION_NAME eq 'settings' || $ACTION_NAME eq ''}
			{tabitem link="/`$MOD_NAME`/settings/" active="0"}Settings{/tabitem}
		{else}
			{tabitem link="/`$MOD_NAME`/settings/" active="0"}Settings{/tabitem}
		{/if}
	{/if}
{/tab}
</div>