<h1>Параметры по моделям</h1>

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

        <div class='clear' style="padding:10px;"></div>

        {form from=$form}
          <fieldset> 
           <legend>Выбор:</legend>
             <label class="required">Марка (производитель):</label>{form_select name="markId" id="markId" options=$marks onChange="xajax_changeTrademark(this.options[this.selectedIndex].value);" style="width:200px;"}<br />
             <label class="required">Модель:</label>{form_select name="modelId" id="modelId" onChange="xajax_SMchangeModel(this.options[this.selectedIndex].value);" style="width:200px;"}<br/>
         </fieldset>
        {/form}
        <br>

        <div id="prop_block" style="display:none">

        </div>

      </div>
    </div>
  </div>
</div>