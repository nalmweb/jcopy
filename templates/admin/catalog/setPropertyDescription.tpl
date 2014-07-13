
<div >
    <textarea rows="22" cols="45" id="desc">{$desc}</textarea>
</div>
<div class="buttons-pannel-pop">
    {linkbutton onclick="$.modal.close(); return false;" name="Отмена" }
    {linkbutton onclick="xajax_setPropertyDesc($propertyId, document.getElementById('desc').value ); return false;" name="Сохранить" }
</div>