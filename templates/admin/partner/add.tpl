{if $partnerId > 0}
  <h1 class="orange">Редактирование каталога</h1>
{else}
  <h1 class="orange">Новый каталог</h1>
{/if}
<p>Пожалуста заполните поля отмечанны *</p>
<br>

{include file="admin/errors.tpl"}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

        <form {$formContent.attributes}>
          <table border=0 cellpadding=0 cellspacing=5>
            <tr>
              <td align="right">
                {$formContent.name.label}
              </td>
              <td align="left">
                {$formContent.name.html}
                <span class="errorField">{$formContent.errors.name}</span>
              </td>
            </tr>
            <tr>
              <td align="right">
                {$formContent.site_url.label}
              </td>
              <td align="left">
                {$formContent.site_url.html}
              </td>
            </tr>
            <tr>
              <td align="right">{$formContent.password_key.label}</td>
              <td align="left">{$formContent.password_key.html}<span class="errorField">{$formContent.errors.password_key}</span></td>
            </tr>
            <tr>
              <td align="right">{$formContent.description.label}</td>
              <td align="left">{$formContent.description.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.unique.label}</td>
              <td align="left">{$formContent.unique.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.price.label}</td>
              <td align="left">{$formContent.price.html}<span class="errorField">{$formContent.errors.price}</span></td>
            </tr>
            <tr>
              <td align="right">{$formContent.penalty.label}</td>
              <td align="left">{$formContent.penalty.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.information.label}</td>
              <td align="left">{$formContent.information.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.min_day.label}</td>
              <td align="left">{$formContent.min_day.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.short_number.label}</td>
              <td align="left">{$formContent.short_number.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.custom_id.label}</td>
              <td align="left">{$formContent.custom_id.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.longitude.label}</td>
              <td align="left">{$formContent.longitude.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.latitude.label}</td>
              <td align="left">{$formContent.latitude.html}</td>
            </tr>
            <tr>
              <td align="right">{$formContent.countryId.label}</td>
              <td align="left">{$formContent.countryId.html}<span class="errorField">{$formContent.errors.countryId}</span></td>
            </tr>
            <tr>
              <td align="right">{$formContent.cityId.label}</td>
              <td align="left">{$formContent.cityId.html}</td>
            </tr>
            <tr>
              <td align="right"><input type="hidden" name="id" value="{$partnerId}"></td>
              <td align="left">{$formContent.submitForm.html}</td>
            </tr>
          </table>
        </form>

      </div>
    </div>
  </div>
</div>
