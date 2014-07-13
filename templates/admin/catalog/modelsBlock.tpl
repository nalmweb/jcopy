{form from=$form}
{form_hidden value=$markId name=markId}
        {if $models}
            {foreach from=$models item=model}
                {form_text name="models["|cat:$model->getId()|cat:"]" value=$model->getName()}
                {form_checkbox value="1" name="display_"|cat:$model->getId()|cat:"" checked=$model->getDisplay() onClick="xajax_setVisibleModel("|cat:$model->getId()|cat:", this.checked); return true;"}<br />
            {/foreach}
        {/if}
{form_text name=models[new]}
    <div class="clear" >&#160;</div>
    {form_submit name=Сохранить value=Сохранить}
{/form}