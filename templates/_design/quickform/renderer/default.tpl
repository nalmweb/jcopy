{capture name=FormTemplate}
    {literal}
    <table border="0" cellpadding="1" cellspacing="1" align="center">
        <form{attributes}>
            {content}
        </form>
    </table>
    {/literal}
{/capture}

{capture name=HeaderTemplate}
    {literal}
    <tr>
        <td align="left" colspan="3">
            <h4>{header}</h4>
        </td>
    </tr>
    {/literal}
{/capture}

{capture name=ElementTemplate}
    {literal}
    <tr>
        <td align="right" valign="top" width="30%">
            <!-- BEGIN required -->
                <span style="color: #FFB13C">*</span>
            <!-- END required -->
            <b>{label}</b>
        </td>
        <td valign="top" align="left">
            {element}
        </td>
        <td valign="top" align="left">
            <font color="#808080">{comment}</font>
        </td>
    </tr>
    {/literal}
{/capture}

{capture name=ErrorsTemplate}
    {literal}
    <tr>
        <td align="left" colspan="3">
            <table width="100%" cellpadding=3 cellspacing="2" border="0" style="border:solid 1px #FF0000;">
                <tr>
                    <td><font color=#FF0000>{errors}</font></td>
                </tr>
            </table>

        </td>
    </tr>
    {/literal}
{/capture}

{capture name=DelimiterTemplate}
    {literal}
	<tr>
		<td colspan=3 style="padding-top:10px;border-bottom:solid 1px #E7F2D4;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3>&nbsp;</td>
	</tr>
    {/literal}
{/capture}

{capture name=RequiredNoteTemplate}
    {literal}
    <tr>
        <td align="left" colspan="3">
            Fields marked with an asterisks <font color="#FFB13C">*</font> are required.
        </td>
    </tr>
    {/literal}
{/capture}