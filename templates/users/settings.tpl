<script language="javascript">
    var Test = new Array();
    Test[0] = "test";
</script>

    {profilemenu color=$menuColor active="settings"}

	{if $currentUser->id == $user->id}
        {tab}

			{tabitem link=$currentUser->getUserPath('bookmarks')}Bookmarks Settings{/tabitem}
			{tabitem link=$currentUser->getUserPath('bookmarks')}Something Else{/tabitem}

        {/tab}

    {/if}

