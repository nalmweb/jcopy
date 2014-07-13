<div class='photo' id='photo_id_{$item->getId()}'>
  <div style="float:left">
    <a href="#null" onclick="delPhoto({$item->getItemId()},{$item->getId()})">
    <img class="png" src="/images/del.png" border="0" width="15px" height="15px" /></a>
  </div>
 <br />
 <input type='hidden' name='item'  value='{$item->getItemId()}' />
 <input type='hidden' name='photo' value='{$item->getItemId()}' />
 <input type='hidden' name='type'  value='{$item->getType()}'   />
</div>