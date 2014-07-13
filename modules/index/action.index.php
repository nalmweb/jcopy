<?php

$usersList = new Socnet_User_Collection();
$this->_page->Template->assign('newestMembers', $usersList->getNewestUsers());

$oSelector = new Socnet_Selector($this->_db);
$users  = $oSelector->getLastUsers();

if(!empty($users))
  $this->_page->Template->assign('users',$users);


if(!isset($_SESSION['user_id'])){
  $anonHead = '<script src="/js/intro.js" type="text/javascript" charset="utf-8"></script>
              <script type="text/JavaScript" src="/js/rounded_corners_lite.inc.js"></script>
              <script type="text/javascript" language="Javascript" charset="utf-8">
              <!--
              	document.write(\'<style type="text/css">#crossfade {visibility:hidden;}<\/style>\');
              //-->
              </script>
              <link rel="stylesheet" href="/css/intro.css" type="text/css" charset="utf-8">
              <!-- CURVES START -->
              <link rel="stylesheet" href="/css/curves.css" type="text/css" charset="utf-8">

              <script type="text/JavaScript">
                window.onload = function()
                {
                     settings = {
                        tl: { radius: 3 },
                        tr: { radius: 20 },
                        bl: { radius: 3 },
                        br: { radius: 20 },
                        antiAlias: true,
                        autoPad: true,
                        validTags: ["div"]
                     }
                    var myBoxObject = new curvyCorners(settings, "curves");
                    myBoxObject.applyCornersToAll();
                }</script>
              ';
  $this->_page->Template->assign('anonHead',$anonHead);
}

$this->_page->Template->assign('bodyContent','index.tpl');