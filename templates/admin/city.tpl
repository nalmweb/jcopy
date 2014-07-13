<h1 class="orange">Управление городами</h1>
<p>Здесь вы можете добовлять или изменять города</p>
<br />
{include file="admin/errors.tpl"}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">
        <form {$formContent.attributes}>

          <table border=0 cellpadding=0 cellspacing=5>
            <tr>
              <td align="right" width="200">Введите название нового города</td>
              <td></td>
            </tr>
            <tr>
              <td align="right" width="200">{$formContent.country.label}</td>
              <td>
              {$formContent.country.html}
              </td>
            </tr>
            <tr>
              <td align="right">{$formContent.name.label}</td>
              <td>
              {$formContent.name.html}
              </td>
            </tr>
            <tr>
              <td align="right"></td>
              <td>{$formContent.save.html}</td>
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
        <td class="tleft">Город</td>
        <td class="tleft">Страна</td>
        <td>Параметры</td>
      </tr>
    {foreach from=$city_array key=number item=arr}
      <tr>
        <td width="40" class="tleft">
          {$arr.id}
        </td>
        <td class="tleft">
          {$arr.name}
        </td>
        <td class="tleft">
          {$arr.countriName}
        </td>
        <td width="40">

        </td>
      </tr>
    {/foreach}
    </table>
  </div>
</div>

{include file="paginator.tpl"}