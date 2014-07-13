<?php /* Smarty version 2.6.16, created on 2014-07-12 16:46:43
         compiled from admin/main.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta description="<?php echo $this->_tpl_vars['DESCRIPTION']; ?>
">
    <meta keywords="<?php echo $this->_tpl_vars['KEYWORDS']; ?>
">
    <title><?php echo $this->_tpl_vars['TITLE']; ?>
</title>
    <link rel="icon" type="image/png" href="/images/admin/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/css/admin/main.css" />
    <script type='text/javascript' src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/menu.js"></script>
    <link type='text/css' href='/css/simplemodal/basic.css' rel='stylesheet' media='screen' />
    <!--[if lt IE 7]>
    <link type='text/css' href='/css/simplemodal/basic_ie.css' rel='stylesheet' media='screen' />
    <![endif]-->
    <script type='text/javascript' src='/js/simplemodal/jquery.simplemodal.js'></script>
        <?php echo $this->_tpl_vars['XajaxJavascript']; ?>

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
    <span><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "version.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></span>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/auth-user.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="wrapper">
    <div class="wrap_right">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['bodyContent'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
    <div class="clear"></div>
</div>
</div>
</body>
</html>