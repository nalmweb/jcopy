<div id='msg'>
<div id="window_title"><strong>Изменить фото </strong></div><br>
 <div id="image"></div>
   <div style="margin: 0px 10px;">
    <div>
     <form method="POST" action="/admin/editTemplate/id/{$common.item_id}/" enctype="multipart/form-data" >
	    <input type="hidden" name="common[type]"  value="{$common.type}"  >
        <input type="hidden" name="common[item]"  value="{$common.item_id}"  >
        <input type="hidden" name="common[photo]" value="{$common.photo_id}" >
        <input type="file"   name="photo_0"/>
        <input type="submit" name="submit" value="Загрузить">
     </form>
    </div>
 <div id="divFileProgressContainer" style="height: 25px;"></div>
 <div id="thumbnails"></div>
</div>
<div class="buttons-pannel-pop">
   <div style="margin-right:0px;">
      {linkbutton onclick="Dialog.cancelCallback()" name="Отмена" }
   </div>
   </div>
</div>