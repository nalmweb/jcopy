<table width="100%" cellpadding=3 cellspacing="2" border="0" style="border:solid 1px #FF0000;">
    <tr>
        <td>
            <font color=#FF0000>
                {foreach item=e from=$errors}
                    {$e|escape:"html"} <br>
                {/foreach}
            </font>
        </td>
    </tr>
</table>