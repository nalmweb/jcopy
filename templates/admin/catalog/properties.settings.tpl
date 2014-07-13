<h1>Управление параметрами</h1>

{$js}
{literal}
<script type="text/javascript" src="/js/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="/js/SWFUpload/handlers.js"></script>
<script>
    var upload1;
    function loadSWFUpload()
    {
        upload1 = new SWFUpload({
            // Backend Settings
            upload_url: "{/literal}/{literal}",
            post_params: {"SWFUploadID" : '{/literal}{$SWFUploadID}{literal}', "galleryId" : '{/literal}{if $gallery}{$gallery->getId()}{else}0{/if}{literal}'},

            // File Upload Settings
            file_size_limit : "102400", // 100MB
            file_types : "*.jpg;*.gif",
            file_types_description : "All Files",
            file_upload_limit : "0",
            file_queue_limit : "0",

            // Event Handler Settings (all my handlers are in the Handler.js file)
            file_dialog_start_handler       : fileDialogStart,
            file_queued_handler             : fileQueued,
            file_queue_error_handler        : fileQueueError,
            file_dialog_complete_handler    : fileDialogComplete,
            upload_start_handler            : uploadStart,
            upload_progress_handler         : uploadProgress,
            upload_error_handler            : uploadError,
            upload_complete_handler         : uploadComplete,
            file_complete_handler           : fileComplete,

            // Flash Settings
            flash_url : "/js/SWFUpload/swfupload.swf",  // Relative to this file (or you can use absolute paths)

            // UI Settings
            ui_container_id : "flashUI1",
            degraded_container_id : "degradedUI1",

            // Debug Settings
            debug: false
        });
        upload1.customSettings.progressTarget = "fsUploadProgress1";    // Add an additional setting that will later be used by the handler.
        upload1.customSettings.cancelButtonId = "btnCancel1";           // Add an additional setting that will later be used by the handler.

    }
    
</script>
{/literal}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div id="ajaxContent" style="display:none">{$ajaxContent}</div>
    <table class="sTable">
      <tr class="first">
         <td class="tleft">Навание</td>
         <td>Ед. измерения</td>
         <td>Тип данных</td>
         <td>Описание</td>
         <td>Дополнительно</td>
         <td>Действия</td>
      </tr>
        {foreach from=$propList item=p}
        <tr>
          <td nowrap="true" class="tleft">
           <div id="div_property_{$p->getId()}">{$p->getName()}<br /><a href="#null" onClick="changeName({$p->getId()}); return false;">изменить</a></div>
           <div id="input_property_{$p->getId()}" style="display:none;">
               <input name="property_{$p->getId()}" id="property_{$p->getId()}" value="{$p->getName()}"><br />
               <a href="#null" onClick="xajax_changePropName({$p->getId()}, document.getElementById('property_{$p->getId()}').value); return false;">Сохранить</a>
           </div>
          </td>
          <td nowrap="true">
            <select name="ud_{$p->getId()}" id="ud_{$p->getId()}" style="width:80%;" onChange="xajax_changePropChar({$p->getId()},this.options[this.selectedIndex].value, 'ud'); return false;">
               {foreach from=$udList key=udId item=ud}
                  <option value="{$udId}" {if $udId == $p->getIdUnitDimension()} selected="selected"{/if}>{$ud}</option>
               {/foreach}
            </select>
          </td>
          <td nowrap="true">
            <select name="pt_{$p->getId()}" id="pt_{$p->getId()}" onChange="xajax_changePropChar({$p->getId()},this.options[this.selectedIndex].value, 'pt'); return false;" >
               {foreach from=$propTypeList key=ptId item=ptl}
                  <option value="{$ptId}" {if $ptId == $p->getIdTypeProperty()} selected="selected"{/if}>{$ptl}</option>
               {/foreach}
            </select>
          </td>
          <td class="tleft">
            {$p->getDescription()}
            <br />
            <a href="#null" onClick="xajax_setPropertyDesc({$p->getId()})">
              Изменить
            </a>
          </td>
          <td nowrap="true">
                {if $p->getIdTypeProperty() == 3}
                <select name="ld_{$p->getId()}" id="ld_{$p->getId()}" style="width:100%;" >
                 {foreach from=$p->getListData() key=ldId item=ld}
                 <option value="{$ldId}" >{$ld}</option>
                 {/foreach}
                </select><br />
                <a href="#null" onClick="xajax_addListData({$p->getId()}); return false;">Изменить</a>
                {/if}
                </td>
                <td>{linkbutton name="Удалить"  onclick="xajax_deleteProp("|cat:$p->getId()|cat:"); return false;"}</td>
        </tr>
        {/foreach}
        <tr>
          <td colspan="6" align="right"><a href="#null" onClick="xajax_addNewProperty(); return false;">+ Добавить</a></td>
        </tr>
    </table>
  </div>
</div>

{literal}
<script type="text/javascript">
<!--
    function changeName(id)
    {   
        var element = 'div_property_'+id;
        document.getElementById('div_property_'+id).style.display = 'none';
        document.getElementById('input_property_'+id).style.display = '';
    }
    function openMyDialog(id){
      //Dialog.window(document.getElementById(id).innerHTML, {className: "alphacube", width:400,height:440});
      $('#'+id).modal();
    }
//-->
</script>
{/literal}
