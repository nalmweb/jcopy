<div style="display:none" id='msg' >
 <div>{$title}</div><br>
 <div><textarea cols="46" rows="10"></textarea></div>
 <div style="float:right;margin-right:10px;margin-top:5px;">
	<input type="button" name="cancel" value="Отмена"  onclick="win1.close()">&nbsp;
	<input type="button" name="send"  value="Отправить" onclick="send()">
 </div>
</div>

function openMyDialog(id) {
   Dialog.window($(id).innerHTML, {className: "alphacube", width:400,height:267, id: "d12" })
   // index++;
}