{if $popup_content eq 'title'}
Add friend.
{/if}

{if $popup_content eq 'body'}
<div id="addfriend_block">
Add friend. Leave the message.<br>

<textarea name="message" id="message" style="width:300px; height:150px;"></textarea>

<input type="button" value="Send friend request" onclick="xajax_add_friend_save({$friend_id}, document.getElementById('message').value);">
</div>
<a href="#" onclick="xajax_closePopup(); return false;">Close Window</a>

{/if}
