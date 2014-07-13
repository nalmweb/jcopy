<div id='msg'>
  <div id="window_title">Изменить логотоп для <strong>{$tm->getName()}</strong></div>
  <br>

  <div id="image"></div>
  <div style="margin: 0px 10px;">
    <div>
      <form method="POST" action="/admin/trademarks/" enctype="multipart/form-data">
        <input type="hidden" name="markId" value="{$tm->getId()}">
        <input type="file" name="logo_{$tm->getId()}"/>
        <br /><br />
        <center><input type="submit" name="submit" value="Загрузить"></center>
      </form>
    </div>
    <div id="divFileProgressContainer"></div>
    <div id="thumbnails"></div>
  </div>
  <center>
    {linkbutton onclick="$.modal.close()" name="Отмена" }
  </center>
</div>
<div class="clear"></div>