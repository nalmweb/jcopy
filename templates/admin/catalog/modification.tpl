<h1 class="orange">Управление модификациями моделей</h1>
<p>Здесь вы можете добовлять или изменять модификацию модели</p>
<br />

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

        <div class='clear' style="padding:10px;">&#160;</div>
      {form from=$form id="change_years"}
        <fieldset>
          <legend>Выбор производителя:</legend>
          <label class="required">Марка (производитель):</label>{form_select name="markId" id="markId" selected=$markId options=$marks onChange="xajax_changeTrademark(this.options[this.selectedIndex].value); return false;" style="width:200px;"}<br />
          <label class="required">Модель:</label>{form_select name="modelId" id="modelId" selected=$modelId options=$models onChange="xajax_selectModel(this.options[this.selectedIndex].value);" style="width:200px;"}<br/>
        </fieldset>

        <br>
        <div id='modification_block'>
          {if $modelId}
            {form_hidden value=$modelId name=modelId}
            {if $modification}
              {foreach from=$modification key=id item=name}
                {form_text name=modification[$id] value=$name}<br />
              {/foreach}
            {/if}
            {form_text name=modification[new]}
            <div class="clear" >&#160;</div>
            {form_submit name=Сохранить value=Сохранить}
          {/if}
        </div>
      {/form}


      </div>
    </div>
  </div>
</div>