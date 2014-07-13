<h1 class="orange">Управление странами</h1>
<p>Здесь вы можете добовлять или изменять страну</p>
<br/>

{include file="admin/errors.tpl"}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

        <form {$formContent.attributes}>
          <table border=0 cellpadding=0 cellspacing=5>
            <tr>
              <td align="right" width="200">{$formContent.country.label}</td>
              <td>{$formContent.country.html}</td>
            </tr>
            <tr>
              <td align="right"></td>
              <td>{$formContent.submitForm.html}</td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<br/>

<div class="black_box mTop10 radius">
  <div class="inner">
    <div id="ajaxContent" style="display:none">{$ajaxContent}</div>
    <table class="sTable">
      <tr class="first">
        <td class="tleft">id</td>
        <td class="tleft">Навание</td>
        <td>Параметры</td>
      </tr>
    {foreach from=$countries_array key=id item=name}
      <tr>
        <td width="40" class="tleft">
          {$id}
        </td>
        <td class="tleft">
          {$name}
        </td>

        <td width="40">

        </td>
      </tr>
    {/foreach}
    </table>
  </div>
</div>

{include file="paginator.tpl"}