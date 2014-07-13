{if $invite==true}
   {include file=$invite_template }
{else}
  {include file="header.tpl"}

  <body>
  <center>
    <div {$onload_attributes} {$body_attributes} style="width:900px; text-align: left">
  	{include file=$menu}
  	{include file=$loginContent}

  	<div class="content"> <pre> {$hot_actions} </pre>

  	{include file=$bodyContent}

    <div id="clear"></div>

  	<input type="hidden" name="ctrl" value="{$controller}" id="ctrl">

    <div id="clear"></div>

    <input type="hidden" name="act"  value="{$action}" id="act">

    <div id="clear"></div>

    {include file="footer.tpl"}
    </div>
  </center>
  </body>
  </html>
{/if}