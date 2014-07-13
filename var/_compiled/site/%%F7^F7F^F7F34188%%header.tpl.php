<?php /* Smarty version 2.6.16, created on 2014-07-12 16:20:39
         compiled from header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta description="<?php echo $this->_tpl_vars['DESCRIPTION']; ?>
">
 <meta keywords="<?php echo $this->_tpl_vars['KEYWORDS']; ?>
">
 <title><?php echo $this->_tpl_vars['TITLE']; ?>
</title>
  <link rel=stylesheet href="/css/default.css" type=text/css>
  <!-- [if lte IE 6]>
  <link rel="stylesheet" type="text/css" href="/css/ie6.css" />
  <![endif] -->
  <link rel='stylesheet' type='text/css' href='/css/alphacube.css'>

  <?php if ($this->_tpl_vars['admin_js']):  echo $this->_tpl_vars['admin_js'];  endif; ?>

  <script type="text/javascript" src="/js/comments_work.js"></script>

  <script type="text/javascript" src="/js/scriptaculous/prototype.js"></script>
  <script language="javascript"  src="/js/scriptaculous/scriptaculous.js" type="text/javascript"></script>
  <script type="text/javascript" src="/js/common.js"></script>
  <script language="javascript"  src="/js/hot_actions.js?114"></script>

  <?php if ($this->_tpl_vars['hot_actions']):  echo $this->_tpl_vars['hot_actions'];  endif; ?>
  <?php if ($this->_tpl_vars['anonHead']): ?>
	  <?php echo $this->_tpl_vars['anonHead']; ?>

  <?php endif; ?>

  <?php if ($this->_tpl_vars['enableGmap']): ?>
        <?php echo $this->_tpl_vars['google_map_header']; ?>

        <?php echo $this->_tpl_vars['google_map_js']; ?>

        <?php echo '
        <!-- necessary for google maps polyline drawing in IE, and how is it made in FF? -->
        <style type="text/css">
        v\\:* {ldelim}
            behavior:url(#default#VML);
        {rdelim}
        </style>
        '; ?>

   <?php endif; ?>
   <?php echo $this->_tpl_vars['XajaxJavascript']; ?>

</head>