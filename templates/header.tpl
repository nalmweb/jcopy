<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta description="{$DESCRIPTION}">
 <meta keywords="{$KEYWORDS}">
 <title>{$TITLE}</title>
  <link rel=stylesheet href="/css/default.css" type=text/css>
  <!-- [if lte IE 6]>
  <link rel="stylesheet" type="text/css" href="/css/ie6.css" />
  <![endif] -->
  <link rel='stylesheet' type='text/css' href='/css/alphacube.css'>

  {if $admin_js}{$admin_js}{/if}

  <script type="text/javascript" src="/js/comments_work.js"></script>

  <script type="text/javascript" src="/js/scriptaculous/prototype.js"></script>
  <script language="javascript"  src="/js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script type="text/javascript" src="/js/common.js"></script>
  <script language="javascript"  src="/js/hot_actions.js?114"></script>

  {if $hot_actions}{$hot_actions}{/if}
  {if $anonHead   }
	  {$anonHead}
  {/if}

  {if $enableGmap}
        {$google_map_header}
        {$google_map_js}
        {literal}
        <!-- necessary for google maps polyline drawing in IE, and how is it made in FF? -->
        <style type="text/css">
        v\:* {ldelim}
            behavior:url(#default#VML);
        {rdelim}
        </style>
        {/literal}
   {/if}
   {$XajaxJavascript}
</head>