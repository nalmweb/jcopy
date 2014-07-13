<div id='msg'>
 <div id="window_title"><strong>Изменить фото</strong></div><br>
    <div id="image"></div>
    <div style="margin: 0px 10px;">
        <div>
        <!-- /mail/trademarks/ -->
            <form  method="POST" action="{$action}" enctype="multipart/form-data">
                <input type="hidden" name="item_id" value="{$item_id}">
                <input type="hidden" name="photo_id" value="{$photo_id}">
                <input type="hidden" name="photos_type" value="{$photos_type}">
                <input type="file"   name="photo_1"/>
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