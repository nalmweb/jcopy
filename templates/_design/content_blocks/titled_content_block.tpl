{strip}
<table width="{$width}" {if $height}height="{$height}"{/if} border="0" cellspacing="0" cellpadding="0" style="margin-left:auto;margin-right:auto;"{if $headerColor=="transp"} class="body"{/if}>
    <tr valign="middle">
        <td width="6" height="21" {if $headerColor=="transp"}class="nav_title_bar"{/if}><img src="/images/contentblock/header_{$headerColor}_left.gif" alt="" width="6" height="21" /></td>
        <td valign="middle" height="21">
            <table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
                <tr>
                    <td style="{if $headerColor!="transp"}background-image:URL('/images/contentblock/header_{$headerColor}_background.gif');background-repeat:no-repeat;background-position:right;background-color:{$color};{else}class="nav_title_bar"{/if} border:1px #000 solid; border-right:0px; border-left:0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><h5 {if $headerColor=="transp"}class="nav_title_bar"{else}style="color:#fff;"{/if}>{$title}</h5></td>
                                <td align="right" style="color:#ffffff;">{$right_html}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="6" height="21"{if $headerColor=="transp"}class="nav_title_bar"{/if}><img src="/images/contentblock/header_{$headerColor}_right.gif" alt="" width="6" height="21" /></td>
    </tr>
    <tr>
        <td background="/images/tbl/content/21{if $headerColor=="transp"}_5{/if}.gif"><img src="{$THEME_PATH}/images/px.gif" alt="" width="1" height="1" /></td>
        <td {if $headerColor!="transp"}bgcolor="#FFFFFF"{/if} align="left" valign="top">{$content}</td>
        <td background="/images/tbl/content/23{if $headerColor=="transp"}_5{/if}.gif"><img src="{$THEME_PATH}/images/px.gif" alt="" width="1" height="1" /></td>
    </tr>
    <tr>
        <td height="8"><img src="/images/tbl/content/31{if $headerColor=="transp"}_5{/if}.gif" alt="" width="6" height="8" /></td>
        <td background="/images/tbl/content/32{if $headerColor=="transp"}_5{/if}.gif"><img src="{$THEME_PATH}/images/px.gif" alt="" width="1" height="1" /></td>
        <td><img src="/images/tbl/content/33{if $headerColor=="transp"}_5{/if}.gif" alt="" width="6" height="8" /></td>
    </tr>
</table>
{/strip}