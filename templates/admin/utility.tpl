<div class="text">

<b>Полезность</b><br>
 {form from=$form}
{foreach from=$utils item=u key=id}
{form_text name=utilities[$id] value=$u}<br />
{/foreach}

<input name="utilities[new]" value="" type="text"><br>

{form_submit value="Сохранить"}

{/form}
</div>