{include file="mailtemplates/_tabs.tpl"}

{contentblock width="100%"}
<table align="center" >
  <tr>
    <td><div style="padding:20px;">
      <b style="font-size:12px;">Извините</b><br>
      <div style="padding-left:20px;"><br>
        There are no members in search results<br>
        <br>
        Use the above utility to search again. <br/>
        If you have a special question, please email <a href="{if $USE_USER_PATH}http://feedback.{$currentUser->login}.{$BASE_HTTP_HOST}/{$LOCALE}/index/{else}http://{$BASE_HTTP_HOST}/{$LOCALE}/feedback/{/if}">Contact Us</a> </div></div></td>
  </tr>
</table>
{/contentblock}