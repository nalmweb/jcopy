<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta description="{$DESCRIPTION}">
    <meta keywords="{$KEYWORDS}">
    <title>{$TITLE}</title>
    <link rel="icon" type="image/png" href="/images/admin/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/css/admin/main.css" />
    <script type='text/javascript' src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/menu.js"></script>
    <link type='text/css' href='/css/simplemodal/basic.css' rel='stylesheet' media='screen' />
    <!--[if lt IE 7]>
    <link type='text/css' href='/css/simplemodal/basic_ie.css' rel='stylesheet' media='screen' />
    <![endif]-->
    <script type='text/javascript' src='/js/simplemodal/jquery.simplemodal.js'></script>
    {*<script type='text/javascript' src='/js/slautaUi/slautaUi.js'></script>*}
    {$XajaxJavascript}
    <!--[if IE 6]>
        <link rel="stylesheet" type="text/css" href="/css/admin/ie6.css" />
        <link rel="stylesheet" type="text/css" href="/css/ie6.css" />
    <![endif]-->
    <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/admin/ie7.css" />
    <![endif]-->
    <!--[if IE 8]>
        <link rel="stylesheet" type="text/css" href="/css/admin/ie8.css" />
    <![endif]-->

    <script type='text/javascript' src='/js/admin/load.js'></script>
</head>


<body class="w">

<div id="loaddingDiv" class="loaddingDivClass">
  <p class="loadDeleteMessage">Подождите пожалуйста! Идет загрузка...<br /><br /></p>
  <center>
    <img src="/images/admin/loading29.gif" class="loadDeleteMessage">
    <br />
    <div id="messageLoadind">
      <p class="loadDeleteMessage"><br />Операция проходит слишком медленно, вы можете скрыть это окно</p>
      <a onclick="Loading.end()">Закрыть</a>
    </div>
  </center>
</div>

<div class="zoom">
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <img src="/images/admin/w_bg.jpg" alt="" class="zoom" style="">
            </td>
        </tr>
    </table>
</div>

<div id="container">
    <div class="logo">
    <a href=""><img src="/images/admin/logo.png" alt="title" title="" /></a>
    <span>{include file="version.tpl"}</span>
</div>

{include file="admin/auth-user.tpl"}

{include file="admin/menu.tpl"}

<div id="wrapper">
    <div class="wrap_right">
      {include file=$bodyContent}
    </div>
    <div class="clear"></div>
</div>
</div>
</body>
</html>