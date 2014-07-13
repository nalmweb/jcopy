<h1>Параметры по годам</h1>

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

      <div class='clear' style="padding:10px;"></div>
      {form from=$form}
        <fieldset>
          <legend>Выбор:</legend>
          <label class="required">Марка
            (производитель):</label>{form_select name="markId" id="markId" options=$marks onChange="xajax_changeTrademark(this.options[this.selectedIndex].value);" style="width:200px;"}
          <br/>
          <label
            class="required">Модель:</label>{form_select name="modelId" id="modelId" onChange="xajax_changeModel(this.options[this.selectedIndex].value);" style="width:200px;"}
          <br/>
          <label
            class="required">Модификация:</label>{form_select name="modificationId" id="modificationId" onChange="xajax_changeModification(this.options[this.selectedIndex].value);" style="width:200px;"}
          <br/>
          <label class="required">Год
            выпуска:</label>{form_select name="yearId" id="yearId" onChange="xajax_changeYear(this.options[this.selectedIndex].value);" style="width:200px;"}
          <br/>
        </fieldset>
      {/form}
        <br>

        <div id="prop_block" style="display:none">

        </div>


      </div>
    </div>
  </div>
</div>