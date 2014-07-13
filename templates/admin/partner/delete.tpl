
{include file="admin/errors.tpl"}

{if !$errors}

<div class="black_box mTop10 radius">
  <div class="inner">
    <div class="form">
      <div class="text">

        <form {$formContent.attributes}>
          <table border=0 cellpadding=0 cellspacing=5>
            <tr>
              <td align="left" width="200"><h1 class="red bold"><img src="/images/admin/icon/red/hash_14x16.png" alt="">Вы действительно хатите удалить каталог '{$partner->getName()}'?</h1></td>
            </tr>
            <tr>
              <td align="left" class="">Удаление каталога, может повлечь за собой необратимые последствия.<br> Вернуть удаленный каталог будет невозможно!</td>
            </tr>
            <tr>
              <td align="left">
                <input class="true" name="trueDel" type="submit" value="Да, я подтверждаю удаление">
                <input class="false" name="falseDel" type="submit" value="Нет, вернуться обратно">
                <input name="partnerId" type="hidden" value="{$partner->getId()}">
              </td>
            </tr>
          </table>
        </form>

      </div>
    </div>
  </div>
</div>

{/if}