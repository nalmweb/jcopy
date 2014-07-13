<form method="POST" enctype="multipart/form-data" name="uploadPhotoForm" action="{$upload_action}" id="uploadPhotoForm">

<div style="padding-top:20px;padding-left:20px;">
<table width="40%" border="0">
 <tr><td>Фото:&nbsp;&nbsp;&nbsp;<input type="file" name="photo_0" id="file"></td></tr>
 <br />
  <tr>
    <td><div style="padding-left:80px;padding-top:20px;" >
       <table width="50%"> 
       <tr>
         <td>
           <input type="button" value="отмена" onclick="doCancel(this.form)" name="cancel" >
         </td>
         <td>
        {submitbutton value="Отправить" }         
         </td>
      </tr>
     </table>    
     <div style="float:left;border:solid 1px #eee;">

      </div>

     <div style="float:left;padding-left:80px;">

      </div>
      
     <!--input type="submit"  name="submitAction"   value="Отправить"  onclick="alert('clicked');" -->
    <!-- input type="submit" name="submitAction" value="отправить"  > -->
  </div>
 </td></tr>
</table>
    <input type="hidden" name="item"  value="{$item_id}"  >
    <input type="hidden" name="photo" value="{$photo_id}" >
    <input type="hidden" name="type"  value="{$photos_type}">
<div id="message" style="font-family:Tahoma, Arial; font-size: 12px; color: #000000; font-weight : bold;"></div>
<div id="photos"></div>
<div id="debug"></div>
<div id="divFileProgressContainer" style="height: 25px;"></div>
<div id="thumbnails"></div>

</div>
</form>