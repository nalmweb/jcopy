<fieldset>
  <legend>Параметры</legend>
  {if $tableValueCheck == 'id_modification'}
    <a onclick="xajax_loadModelProperty($('#modelId').val())">Загрузить из модели</a>
  {elseif $tableValueCheck == 'id_model_god'}
    <a onclick="xajax_loadModelProperty($('#modelId').val())">Загрузить из модели</a>
    <a onclick="xajax_loadModificationProperty($('#modificationId').val())">Загрузить из модификации</a>
  {/if}

{form from = $form id="properties"}
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table border="0">
          {foreach from=$modelGod->getProperties() key=id item=pl}
            <tr>
              <td style="border-bottom: 1px solid #000000" valign="top"  width="20%">
                <label>{$pl->getProperty()->getName()}
                  {if $pl->getProperty()->getIdUnitDimension()}
                    , {$pl->getProperty()->getUnitDimension()->getName()}{/if}
                </label><br/>
              </td>
              <td style="border-bottom: 1px solid #000000">
                {if $pl->getProperty()->getIdTypeProperty() == 3}
	                {*{form_select id="property"|cat:$pl->getProperty()->getId()|cat:"" name="property["|cat:$pl->getProperty()->getId()|cat:"]" size="4" multiple="multiple" options=$pl->getValuesListData()->getData() selected=$pl->getValuesList() style="width:250px"}*}
	                <table>
                    {foreach from=$pl->getValuesListData()->getData() key=key item=item}
                      <tr>
                        <td width="20"><input type="checkbox" id="name_{$key}" name="property[{$key}]" value="{$pl->getProperty()->getId()}" {if $pl->checkPropertyValueList($key, $tableValueCheck, $modelGod->getId()) } checked="checked"{/if}></td>
                        <td>{$item}</td>
                      </tr>
                    {/foreach}
                  </table>
	              {else}
	                {form_text id="Tproperty"|cat:$pl->getProperty()->getId()|cat:"" name="Tproperty["|cat:$pl->getProperty()->getId()|cat:"]" value=$pl->getValue()}
	              {/if}
              </td>
            </tr>
          {/foreach}
          <tr>
            <td colspan="2">
              <div class="RightButton">{linkbutton name="Сохранить" onclick="xajax_saveData(xajax.getFormValues('properties')); return false;"}</div>
              {form_hidden name="modelGodId" id='modelGodId' value=$modelGod->getId()}
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
{/form}
</fieldset>