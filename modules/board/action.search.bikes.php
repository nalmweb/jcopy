<?
  // dump($_POST);
  //error_reporting(E_ALL);
  $cat_id=1;
  $page = getUrlParam('page');

  if(empty($page))
  	 $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
  
  $bSearch=false;
  $markId=0; $modelId=0; $typeId=0; $year='';$price=''; $probeg =0;
  $is_photo=0; $frm=''; $search_form='';
  
  // 
  if($_SERVER['REQUEST_METHOD']=='POST')
  {
    $markId = isset($_POST['markId'])?intval($_POST['markId']):0;
    $modelId= isset($_POST['modelId'])?intval($_POST['modelId']):0;
    $typeId = isset($_POST['typeId'])?intval($_POST['typeId']):0;
    $year   = isset($_POST['year'])?$_POST['year']:0;
    $price  = intval($_POST['price']);
    $probeg = intval($_POST['probeg']);
    $is_photo=isset($_POST['is_photo'])?$_POST['is_photo']:0;
    $bSearch=true;
    
    // SET HIDDEN FORM:
	$frm['modelId'] = $modelId;
    $frm['markId']  = $markId;
    $frm['typeId']  = $typeId;
    $frm['year']	= $year; 
    $frm['price']   = $price;
    $frm['probeg']  = $probeg;
    $frm['is_photo']= $is_photo;
    // saving post into hidden form - seems to be a hole in security.
    $this->_page->Template->assign('frm',$frm);
    $this->_page->Template->assign('search_form',$frm);
  }
  
  $boardList   ='';
  $this->_page->Template->assign('cat_id',$cat_id);
  $this->_page->Template->assign('crumbs',$this->crumbs);
  $this->_page->Xajax->registerUriFunction("changeTrademarkSearch","/ajax/changeTrademarkSearch/");
    
  $sTrademark = getUrlParam(Socnet::$urlParams,"trademark");
  $sModel 	  = getUrlParam(Socnet::$urlParams,"model");
  
  $sTrademark = '';
  // List like: board/listBikes/
  if(!empty($sTrademark))
  	  $mark=$trademark_id=$this->getTrademarkId($sTrademark,$cat_id);
  
  // Common for all pages::  
  $board=new Socnet_Board_List();  
  $board->setCatId($cat_id);
  $board->setTrademarkId($markId);
  $board->setModelId($modelId);
  $board->setTypeId($typeId);
  $board->setYearArray($year);
  $board->setPriceArray($price);
  $board->setProbegArray($probeg);
   $board->shouldCount(true); // for paging;
   $board->setOrder("reg_date DESC");    
   $board->returnAsAssoc(false);
   $board->setListSize($this->pageSize)->setCurrentPage($page);

   // get marks
  $mark = new Socnet_Catalog_Trademark_List();
  $mark->returnAsAssoc(true);
  $mark->addWhere("id_type_auto=$cat_id");
  $marks = $mark->getList();
  $trademarks = $marks; // for above listing.
  $marks[0] = "Все производители";
  	// ---->>>
  	ksort($marks);
  	ksort($trademarks);
  	//dump($marks);
  	//$this->_page->Template->assign('trademark_name',$trademark_name);
  	
  	if(!empty($trademark_id))
  	{
  	   // echo "sdf";
  	   $this->_page->Template->assign('selectedMarkId',$markId);
  	   // get list of models
  	   $model = new Socnet_Catalog_Model_List();
  	   $model->returnAsAssoc(true);
  	   $model->addWhere("id_trademark=$markId");
  	   $models=$model->getList();
  	   
  	   
  	   
  	   // dump($models);
  	   $models_ids   =array_keys($models);
  	   $models_names =array_values($models);
  	   
  	   $models_ids[0]   =0;
  	   $models_names[0] ="Все модели";
  	   
  	   $this->_page->Template->assign('models_ids',$models_ids);
  	   $this->_page->Template->assign('models_names',$models_names);
  	   
  	   if(!empty($modelId))
  	   	  $this->_page->Template->assign('selectedModelId',$modelId);
  	}
  	
  	$this->_page->Template->assign('trademarks',$trademarks);
  	
	// GET MARKS
  	$mark_ids  =array_keys($marks);
  	$mark_names=array_values($marks);
  	$this->_page->Template->assign('mark_ids',$mark_ids);
  	$this->_page->Template->assign('mark_names',$mark_names);

  	// GET TYPES
    $bikeType = new Socnet_Catalog_Property_Item();
    $bikeType->setId(1);
    $types = $bikeType->getListData();   
    $types[0]="Выберите тип";
    ksort($types);
    
    $type_ids   = array_keys($types);
    $type_names = array_values($types);
    $this->_page->Template->assign('type_ids',$type_ids);
    $this->_page->Template->assign('type_names',$type_names);  	
  	
  /*$type=new Socnet_Catalog_Category_List();
    $type->returnAsAssoc(true);
    $types=$type->getList();
    $types[0]="Выберите тип";
    ksort($types);*/
    $cur_year =  date('Y');
    $years = range(1950,$cur_year);
    foreach ($years as $year)
  		 $years[$year] = $year;
    
    $this->_page->Template->assign('years',$years);
    $this->_page->Template->assign('cur_year',$cur_year);
    
    
    
  // A LIST OF ADs::
  $boardList=$board->getList();
  $num_items=$board->getNumItems();
  $this->setPaginator($num_items,$this->oUrl->getCurrentUrl());
  
  $this->_page->Template->assign('bikeList',$boardList);
  $this->_page->Template->assign('bodyContent', "board/board.se_results.bikes.tpl");
?>