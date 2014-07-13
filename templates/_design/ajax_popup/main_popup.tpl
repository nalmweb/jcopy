{if $block_layer}                
<div id="block_layer_{$div_id}" style="z-index:3000;position:absolute;top:0;left:0;width:100%;background-image:URL('images/block_layer.gif');background-attachment:scroll;/*background-color:#EAEAEA;*/"></div>
{/if}
<div id="main_popup_{$div_id}" style="z-index:4000;position:absolute;top:{$pos_top|default:"0"};left:{$pos_left|default:"0"};">
<table cellpadding="0" cellspacing="0" border=0>
{if $title}
	  <tr>
	    <td>
	      <div id="main_popup_title_position_{$div_id}">
    {if $title_position == "left"}
	  <table cellpadding="0" cellspacing="0" width="100%">
	    <tr>
	      <td align="right">
	      <center><b><div id="main_popup_title_{$div_id}" style="{$style_title|default:"border-left:1px #000000 solid;border-right:1px #000000 solid;border-top:1px #000000 solid; background-color:#EAEAEA;"}padding:5px 20px 0px 20px;">{$title}</div></b></center>
	      </td>
	      <td style="{$style_title2|default:"border-bottom:1px #000000 solid;width:40%;"}">
	      &nbsp;
	      </td>
	    </tr>
	  </table>
    {else}            	    	  
	  <table cellpadding="0" cellspacing="0" width="100%">
	    <tr>
	      <td style="{$style_title2|default:"border-bottom:1px #000000 solid;width:40%;"}">
	      &nbsp;
	      </td>
	      <td align="right">
	      <center><b><div id="main_popup_title_{$div_id}" style="{$style_title|default:"border-left:1px #000000 solid;border-right:1px #000000 solid;border-top:1px #000000 solid; background-color:#EAEAEA;"}padding:5px 20px 0px 20px;">{$title}</div></b></center>
	      </td>
	    </tr>
	  </table>
    {/if}
	  </div>
	    </td>
      </tr>
{/if}      
      <tr>
	    <td width="100%">
	      <div id="main_popup_content_{$div_id}" style="{$style_body|default:"border-left:1px #000000 solid;border-right:1px #000000 solid;border-bottom:1px #000000 solid; background-color:#EAEAEA;"}padding:10px;height:{$height|default:"100"};width:{$width|default:"100"};">{$body|default:"&nbsp;"}</div>
	    </td>
      </tr>
    </table>
</div>