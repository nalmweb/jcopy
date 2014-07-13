{form from=$form}
   {form_hidden value=$modelId name=modelId}
   {if $modification}
       {foreach from=$modification item=model}
           {form_text name="modification["|cat:$model->getId()|cat:"]]" value=$model->getModification()}
           {form_checkbox value="1" name="display_"|cat:$model->getId()|cat:"" checked=$model->getDisplay() onClick="xajax_setVisibleModification("|cat:$model->getId()|cat:", this.checked); return true;"}<br />
       {/foreach}
   {/if}
   {form_text name=modification[new]}
       <div class="clear" >&#160;</div>
       {form_submit name=Сохранить value=Сохранить}
{/form}