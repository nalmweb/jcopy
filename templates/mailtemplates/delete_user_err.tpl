{include file="mailtemplates/_tabs.tpl"}

{contentblock width="100%"}
<table align="center" >
  <tr>
    <td><div style="padding:20px;">
      <b style="font-size:12px;">We are sorry</b><br>
      <div style="padding-left:20px;"><br>
        Last operation failed.<br>
        <br>
        <a href="{if $USE_USER_PATH}{$use_user_path}{$LOCALE}/settings/{else}/{$LOCALE}/{$MOD_NAME}/settings/{/if}">Manage settings</a> </div></div></td>
  </tr>
</table>
{/contentblock}