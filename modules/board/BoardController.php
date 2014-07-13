<?php

define('NOT_FOUND', "Объявление не найдено" );

class BoardController extends Socnet_Controller_Action
{
	private $oUrl;
	private $oPaginator;
	
	private $pageSize =15;
	private $frameSize=10;
	private $rssSize=15;
	private $crumbs;	
	private $m_table = "board__bikes";
	
	private $message;

	// This is that...
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
    	parent::__construct($request, $response, $invokeArgs);
        $this->_page->setTitle(Socnet::t('Обьявления'));
        $this->_page->Template->assign('menuContent','_design/menu_content/menu_content.tpl');
        $this->params = $this->_getAllParams();
        $this->oUrl 	  = new Socnet_URL();
        $this->oPaginator = new Socnet_Paginator($this->oUrl,5,1,$this->pageSize,$this->frameSize);
        //Singular!
	    $this->setCrumbs();
	    $this->_page->Template->assign('controller', 'board');
    }
    
    private function setCrumbs()
    {
    	$this->crumbs=array();
    	$this->crumbs[0] = "<a href='http://".BASE_HTTP_HOST."/'>Главная</a>";
    	$this->crumbs[1] = "<a href='http://".BASE_HTTP_HOST."/board/'>Объявления</a>";
    }
    
    public function isLoggedIn()
    {		
		if(!empty($_SESSION['user_id']))
		{
			return true;
		}
		else
		{
			header("Location: /error/registration/");
			return false;
		}
	}
    
    public function indexAction(){
    	include_once('action.index.php');    
    }
    
    public function rssAction(){
    }
    
    public function itemAction(){
    	include_once('action.item.php');		
    }
    
    public function outoflimitAction() { include_once('action.outoflimit.php'); }
    
    public function infoAction()	   { include_once('action.info.php'); }
    
    
    // --> ADD 
    public function addAutoAction(){
       if($this->isLoggedIn()) 
    	include_once('action.addbike.php');
    }

    
    // --> LISTs
    // 
    public function listAutoAction(){
    	include_once('action.list.bikes.php');
    }

    

    // --> SEARCH
    // connected with  
    public function searchAutoAction(){
       	include_once('action.search.bikes.php');	
    }

    
    /**
     *   @param:  $id_type_auto - category of   
     *   @return: trademark_id 
     */
    function getTrademarkId($sTrademark,$id_type_auto)
    {
      $sql=$this->_db->select()->from("catalog__trademark")->where("name=?",$sTrademark)->where("id_type_auto=?",$id_type_auto);
      $rs=$this->_db->fetchAll($sql);
      if(!empty($rs))
      {
		return $rs[0]['id'];
      }
      else return 0;
    }
    
    function getTrademarkName($trademark_id,$id_type_auto){
      $sql=$this->_db->select()->from("catalog__trademark")->where("id=?",$trademark_id)->where("id_type_auto=?",$id_type_auto);
      $rs=$this->_db->fetchAll($sql);
      if(!empty($rs))
      {
		return $rs[0]['name'];
      }
      else return 0;
    }
    
    //|-=>
    // What is it man?
    // This is that
    function getModelId($model_name,$trademark_id,$cat_id)
    {
      $sql=$this->_db->select()->from("catalog__model")
      						   ->where("name=?",$model_name)
      						   ->where("id_trademark=?",$trademark_id);
      //echo "[$sTrademark], sql  = ".$sql->__toString();
      $rs=$this->_db->fetchAll($sql);
      //dump($rs);
      if(!empty($rs))
      {
		return $rs[0]['id'];
      }
      else return 0;
    }
    
    function getTypeName($type_id)
    {
      $sql=$this->_db->select()->from("board__details_names")->where("id=?",$type_id);
      $rs=$this->_db->fetchAll($sql);
      // dump($rs);
      if(!empty($rs))
      {
		return $rs[0]['name'];
      }
      else return 0;
    }

    
    /*-=============>>>>
      @param: $total - the number of items
	  @param: $url   - the url 
     */
    function setPaginator($total,$url)
    {
      // $page
      $page=getUrlParam('page');
      
      if(!empty($page))
      	  $offset = intval($page)*$this->pageSize;
      else
      {
         $offset=0;
         $page  =isset($_REQUEST['page'])?$_REQUEST['page']:-1;
         
         if($page==-1)
         	$page=intval($total/$this->pageSize); 
      }
      $this->oUrl->setUrl($url);
      $this->oPaginator->setNumRows($total);
      $info = $this->oPaginator->getPagingInfo($page);
      // dump($info);
      $this->_page->Template->assign('pgr',$info);
    }
    
    function getMessage(){
    	return $this->message;
    }
    
    function setMessage($type){
    	$this->message=$type;
    }

	/**
	 *   
	 */    
    public function checkCanAdd($cat_id)
    {
	   $item = new Socnet_Board_Item($cat_id);
	   
	   if(!$item->canAdd())
	   {
	      $this->_redirect("/board/outoflimit/");
	   }
    }
}
?>