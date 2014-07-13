<?php
/**
 *
 *
 * @copyright  Copyright (c) 2006
 */

class Socnet_Common_Page
{
    private $_title;        // the title of current page
    private $_keywords;     // keywords
    private $_description;  // site description
    private $_feed;         // feed
    private $_style;        // style
    public  $Locale;
    public  $Template;      // Template object
    public  $Config;
    public  $Access;
    public  $Xajax;
    public  $needXajaxInit;


    public function __construct()
    {
        require_once(ENGINE_DIR.'/Xajax/xajax.inc.php');
        require_once(ENGINE_DIR.'/Xajax/xajaxResponse.inc.php');
        require_once(ENGINE_DIR.'/Xajax/xajaxPopup.php');
		
        $this->Template = new Socnet_View_Smarty();
        $this->Config   = new Socnet_Common_DBConfig();
        //$this->Access   = new Socnet_Access();
        $this->Xajax    = new xajax();
        $this->Xajax->bDebug = false;
        $this->needXajaxInit = false;
        $this->Template->assign('CURRENT_PAGE', $_SERVER['REQUEST_URI']);
        $this->Template->assign('Access', $this->Access);
    }

    public function setTitle($title)
    {
        $this->_title = $title;
        $this->Template->assign('TITLE', $this->getTitle());
    }

    public function getTitle()
    {
        return SITE_NAME_AS_STRING . " :: " . $this->_title;
    }
    
    /*public function setLayout($layout){
    	$this->Template->setLayout($layout);
    }*/

    public function setKeywords($keywords)
    {
        $this->_keywords = $keywords;
        $this->Template->assign('KEYWORDS', $this->getKeywords());
    }

    public function getKeywords()
    {
        return $this->_keywords;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
        $this->Template->assign('DESCRIPTION', $this->getDescription());
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setFeed($feed_link)
    {
        $this->_feed = $feed_link;
        $this->Template->assign('FEED', $this->getFeed());
    }

    public function getFeed()
    {
        return $this->_feed;
    }

    public function setStyle($style_name)
    {
        $this->_style = $style_name;
        $this->Template->assign('STYLE', $this->_style);
    }

    public function getStyle()
    {
        return $this->_style;
    }

    public function initAjax()
    {
        if ( $this->needXajaxInit == true ) {
            $this->Xajax->processRequests();
        }
        $this->Template->assign('XajaxJavascript', $this->Xajax->getJavascript("", "/js/xajax.js"));
    }

    public function addAjaxPopup()
    {

    }
}
