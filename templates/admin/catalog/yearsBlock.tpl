{form from=$form}
   {form_hidden value=$modificationId name=modificationId}
   {form_hidden value=$modelId name=modelId}
   {form_hidden value=$markId name=markId}

   {if $years}
       {foreach from=$years item=model}
           {form_text name="years["|cat:$model->getId()|cat:"]]" value=$model->getYear()}
           {form_checkbox value="1" name="display_"|cat:$model->getId()|cat:"" checked=$model->getDisplay() onClick="xajax_setVisibleYear("|cat:$model->getId()|cat:", this.checked); return true;"}<br />
       {/foreach}
   {/if}
   {form_text name=years[new]}
       <div class="clear" >&#160;</div>
       {form_submit name=Сохранить value=Сохранить}
{/form}