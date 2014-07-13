
<h1 class="orange">Управление моделями производителей</h1>
<p>Здесь вы можете добовлять или изменять модели</p>
<br />

<div class="black_box mTop10 radius">
    <div class="inner">
        <div class="form">
            <div class="text">

                <div class='clear' style="padding:10px;">&#160;</div>
                {form from=$form id="change_models"}
                  <fieldset>
                   <legend>Выбор производителя:</legend>
                     <label class="required">Марка (производитель):</label>{form_select name="markId" id="markId" selected=$markId options=$marks onChange="xajax_selectTrademark(this.options[this.selectedIndex].value); return false;" style="width:200px;"}<br />
                 </fieldset>

                   <br>
                    <div id='models_block'>
                    {if $markId}
                        {form_hidden value=$markId name=markId}
                        {if $models}
                            {foreach from=$models item=model}
                                {form_text name=models[$model->getId()] value=$model->getName()}{form_checkbox checked=$model->getDisplay() name="display"}<br />
                            {/foreach}
                        {/if}
                        {form_text name=models[new]}
                            <div class="clear" >&#160;</div>
                            {form_submit name=Сохранить value=Сохранить}
                    {/if}
                    </div>
                {/form}

            </div>
        </div>
    </div>
</div>