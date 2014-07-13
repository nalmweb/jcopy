<?php
class RssController extends Socnet_Controller_Action
{
   private $rssSize=20;
	
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        //$this->_page->setTitle(Socnet::t('RSS Лента'));
        //$this->_page->Template->assign('menuContent','_design/menu_content/menu_content.tpl');
        //$this->params = $this->_getAllParams();
	    $this->_page->Template->assign('controller', 'news');
    }
    
    // 
    public function newsAction( )
    {
    	$feed = new Socnet_Feed($this->_db,$this->rssSize);
     	$feed->createFeed('news');
     	
    	$filename = $_SERVER['DOCUMENT_ROOT']."/upload/rss/motofriends.ru.news.xml";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
    	print($contents);
    	exit; 
    }
    
    public function photosAction(){
    
    	$feed = new Socnet_Feed($this->_db,$this->rssSize);
     	$feed->createFeed('photos');
    	$filename = $_SERVER['DOCUMENT_ROOT']."/upload/rss/motofriends.ru.photos.xml";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
    	print($contents);
    	exit;
    }
}