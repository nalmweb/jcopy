{form from = $form id="properties"}
<fieldset>
<legend>Параметры</legend>
<table border="0">
{foreach from=$model->getProperties() key=id item=pl}
<tr>
    <td>
        <label>{$pl->getProperty()->getName()}
        {if $pl->getProperty()->getIdUnitDimension()}, {$pl->getProperty()->getUnitDimension()->getName()}{/if}
        </label><br />
    </td>
    <td>
        {if $pl->getProperty()->getIdTypeProperty() == 3}
            {form_select id="property"|cat:$pl->getProperty()->getId()|cat:"" name="property["|cat:$pl->getProperty()->getId()|cat:"]" options=$pl->getValuesListData()->getData() selected=$pl->getValuesList()}
        {else}
            {form_text id="property"|cat:$pl->getProperty()->getId()|cat:"" name="property["|cat:$pl->getProperty()->getId()|cat:"]" value=$pl->getValue()}
        {/if}    
    </td>
</tr>
{/foreach}
<tr>
<td colspan="2">
  <div class="RightButton"> {linkbutton name="Сохранить" onclick="xajax_SMsaveData(xajax.getFormValues('properties')); return false;"}</div>
  {form_hidden name="modelId" id='modelId' value=$model->getId()}
</td>  
</tr>  
{/form}