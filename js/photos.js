function deleteImage(photo_id)
{
  var elem= document.getElementById('row_'+photo_id);
  	  elem.parentNode.removeChild(elem);
  var message = $('message');
  message.style.display='block';
  message.innerHTML = "<span style='color:#F0CC07;font-size:18px;padding-left:7px;padding-top:7px;'>Фото удалено</span>";
  setTimeout("fade('message')",1000);
}

function fade(id){
	new Effect.Fade(id);
}

function openMyDialog(id){
   Dialog.window(document.getElementById(id).innerHTML, {className: "alphacube", width:400,height:250});
}
function doCancel(form){
    Dialog.cancelCallback();
} 

function check(id)
{
	var file = document.getElementById(id);
	
	if(''==file.value || null==file.value)
	{
	    alert ('Введите имя файла.');
		return false;
	}
	else
	{
	   alert('ok');
	   return true;
	}
}
