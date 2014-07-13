<script type="text/javascript" src="/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/js/swfupload/handlers.js"></script>
{$js}
{include file='admin/menu.tpl'}
{literal}
<script type="text/javascript" language="JavaScript" src="/js/JsHttpRequest/JsHttpRequest.js"></script>
<script type="text/javascript" language="JavaScript" >
function doLoad(value){
    var req = new JsHttpRequest();
    req.onreadystatechange = function()
    {
        if (req.readyState == 4) {
        	document.getElementById('message').innerHTML = req.responseJS.message;
        	alert(req.responseJS.images);
            addPhoto(req.responseJS.images);
            document.getElementById('debug').innerHTML = req.responseText;
        }
    }
    req.open(null, 'http://motofriends.my/ajax/uploadPhoto/', true);
    req.send( { 'file': value } );
 }
 // 
 function addPhoto(images)
 {
   var elem = document.getElementById('photos');
   c = document.createElement("div");
   c.innerHTML = images;
   elem.appendChild(c);    
 }
 // 
 function deletePhoto(id){
    var elem=document.getElementById('photo_'+id);
    elem.innerHTML='';
 }
</script>
{/literal}

<div id="ajaxContent" style="display:none">{$ajaxContent}</div>

<form {$formContent.attributes} enctype="multipart/form-data" >
   {$formContent.hidden}
	<div id="page_title"><h1>Редактирование шаблона письма</h1></div>
	  <br>
		<div id="news_block">
		 {if $formContent.errors} {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}{/if}           
		 {$formContent.description.label} {$formContent.description.html}
		 <br><br>
		 {$formContent.templateKey.label} {$formContent.templateKey.html}
		 <br><br><br>
			{$formContent.content.label}<br>{$formContent.content.html}
		 <br /><br />
<!-- <table id="mail_photos"><tr></tr> -->
<!--  show list of photos -->
<div id="photos" >
{foreach from=$photos item=photo}
   <div >http://{$BASE_HTTP_HOST}{$photo->getPhotoPath()}<BR />
    <img src="{$photo->getPhotoPath()}?{$rand}" />
    	<a href="#null" onclick="xajax_delPhoto({$common.type},{$photo->getItemId()},{$photo->getId()}); return false;">Удалить фото</a>
     <div id="photo_{$photo->getId()}">
        <a href="#" onclick="xajax_changePhoto( {$photo->getItemId()}, {$photo->getId()} ); return false;">Изменить фото</a>
     </div>
   </div>
  <br />
{/foreach}
</div>
<div id="divFileProgressContainer" style="height: 25px;"></div>
<div id="thumbnails"></div>
<!-- <a href="#null" onclick="xajax_uploadPhoto(); return false;">Добавить фото</a>   -->
</div>
<input type="hidden"  name="common[item]"  value="{$common.item_id}">
<input type="hidden"  name="common[photo]" value="{$common.photo_id}">
<input type="hidden"  name="common[type]"  value="{$common.type}" >

 Добавление фото:<br /><br />
 <input type="file" name="photo_0" /><br />
 <input type="file" name="photo_1" ><br />
 <input type="file" name="photo_2" ><br />
 <input type="file" name="photo_3" ><br />
 <input type="file" name="photo_4" ><br />
 <input type="file" name="photo_5" ><br />
 <input type="file" name="photo_6" ><br />
 <input type="file" name="photo_7" ><br />
 <br> 
  <div style="padding-left:140px;padding-top:20px;">{submitbutton value="Сохранить" }</div>
</form>
<!-- <form enctype="multipart/form-data" name="form22" action="http://motofriends.my/news/testUploadSubmit/"  method="POST" >
  Фото: &nbsp;&nbsp;&nbsp;<input type="file" name="photo_1" size="80"><br/>
  <input type="button" value="Upload the image" onclick="doLoad(this.form)">
  <input type="hidden"  name="item"  value="{$common.item_id}"  >
  <input type="hidden"  name="photo" value="{$common.photo_id}" >
  <input type="hidden"  name="type"  value="{$common.type}"     >
  <input type="submit" name="btn" value="submit"   />
</form>
-->
<!-- 
<form enctype="multipart/form-data" name="form" >
  Фото: &nbsp;&nbsp;&nbsp;<input type="file" name="photo_1" size="80"><br/>
  <input type="button" value="Загрузить фото" onclick="doLoad(this.form)">
  <input type="hidden"  name="item"  value="{$common.item_id}"  >
  <input type="hidden"  name="photo" value="{$common.photo_id}" >
  <input type="hidden"  name="type"  value="{$common.type}"     >
</form>
-->
<div id="message" style="font-family:Tahoma, Arial; font-size: 12px; color: #000000; font-weight : bold;"></div>
<div id="photos"></div>
<div id="debug"></div>
{literal}
<script type="text/javascript">
<!--
function openMyDialog(id)
{
  Dialog.window(document.getElementById(id).innerHTML, {className: "alphacube", width:400,height:250});
}
//-->
</script>
{/literal}