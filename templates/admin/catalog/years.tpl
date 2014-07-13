
<h1 class="orange">Управление годами производства</h1>
<p>Здесь вы можете добовлять или изменять год производства автомобиля</p>
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

            <br />
             <label class="required">Модель:</label>
             {form_select name="modelId" id="modelId" selected=$modelId options=$models onChange="xajax_changeModel(this.options[this.selectedIndex].value);" style="width:200px;"}<br/>
            <br>
             <label class="required">Модификация:</label>
             {form_select name="modificationId" id="modificationId" selected=$modificationId options=$modification onChange="xajax_selectModification(this.options[this.selectedIndex].value, $('#markId').val(), $('#modelId').val());" style="width:200px;"}
          </fieldset>

           <br>
            <div id='years_block'>
            {if $modificationId}
                {form_hidden value=$modelId name=modelId}
                {form_hidden value=$markId name=markId}
                {form_hidden value=$modificationId name=modificationId}

                {if $years}
                    {foreach from=$years key=id item=name}
                        {form_text name=years[$id] value=$name}<br />
                    {/foreach}
                {/if}
                {form_text name=years[new]}
                    <div class="clear" >&#160;</div>
                    {form_submit name=Сохранить value=Сохранить}
            {/if}
            </div>
        {/form}


      </div>
    </div>
  </div>
</div>