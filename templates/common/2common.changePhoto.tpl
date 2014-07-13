{literal}
<script type="text/javascript" language="JavaScript"   src="/js/JsHttpRequest/JsHttpRequest.js"></script>
<script type="text/javascript" language="JavaScript">

 function doLoad(value)
 {
    var req = new JsHttpRequest();
    req.onreadystatechange = function()
    {
        if (req.readyState == 4) {
        	document.getElementById('message').innerHTML = req.responseJS.message;
            addPhoto(req.responseJS.images);
            document.getElementById('debug').innerHTML = req.responseText;
        }
    }
    req.open(null, 'http://motofriends.my/ajax/uploadPhoto/', true);
    req.send( { 'file': value } );
 }
 
 
 // images - an item with: <img >file
</script>
{/literal}
<div style="padding-top:20px;padding-left:20px;">

<form enctype="multipart/form-data" name="form" action="{$upload_action}" method="POST">
<table width="40%">
 <tr><td>
    Фото: &nbsp;&nbsp;&nbsp;<input type="file" name="photo_0" >
    </td>
  <tr><td>
    <input type="button" value="отмена" onclick="doCancel(this.form)">
    <input type="submit" value="Отправить" >
   </td></tr>
    <input type="hidden"  name="item"  value="{$item_id}"  >
    <input type="hidden"  name="photo" value="{$photo_id}" >
    <input type="hidden"  name="type"  value="{$photos_type}">
</table>

<div id="message" style="font-family:Tahoma, Arial; font-size: 12px; color: #000000; font-weight : bold;"></div>
<div id="photos"></div>
<div id="debug"></div>
<div id="divFileProgressContainer" style="height: 25px;"></div>
<div id="thumbnails"></div>
</form>
</div>
