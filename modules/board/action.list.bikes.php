<? 
   $cat_id=1;
   $page = getUrlParam(Socnet::$urlParams,'page');
/**   
 * BASE_URL/board/listbikes/		     - trademarks 
 * BASE_URL/board/listbikes/t/xxx/		 - models
 * BASE_URL/board/listbikes/t/xxx/m/xxx/ - model
     [0] => 
     [1] => board
     [2] => listbikes
     [3] => [trademark]
     [4] => [Kawasaki]
     [5] => model
     [6] => model_name | changeTrademark
*/
  $bSearch=false;
  // search
  if($_SERVER['REQUEST_METHOD']=='POST')
  {
    $markId = intval($_POST['markId']);
    $modelId= intval($_POST['modelId']);
    $typeId = intval($_POST['typeId']);
    $year   = $_POST['year'];
    $price  = $_POST['price'];
    $probeg = $_POST['probeg'];
    $bSearch=true;
  }
  $trademark   ='';
  $trademark_id=0;
  $model_name  ='';
  $model_name = getUrlParam('model');
  //echo "[$model_name]";
  $sTrademark = getUrlParam('trademark');
  $trademark_name='';
  $this->_page->Template->assign('crumbs',$this->crumbs);
  $this->_page->Template->assign('cat_id',$cat_id);
  $boardList='';
  $this->_page->Xajax->registerUriFunction("changeTrademarkSearch","/ajax/changeTrademarkSearch/");
  
  // Common for all pages::
  $board=new Socnet_Board_List();
  $board->setCatId($cat_id);
  $board->shouldCount(true); // for paging;
  $board->setOrder("reg_date DESC");    
  $board->returnAsAssoc(false);
  $board->setListSize($this->pageSize)->setCurrentPage($page);  

  if(!empty($sTrademark))
  	  $trademark_id=$this->getTrademarkId($sTrademark,$cat_id);  	  
  	  
  if( empty($model_name) && empty($sTrademark) )
  {
  	$mark = new Socnet_Catalog_Trademark_List();
  	$mark->returnAsAssoc(true);
  	$mark->addWhere("id_type_auto=$cat_id");
  	$marks = $mark->getList();
  	$trademarks = $marks; // for above listing.
  	$marks[0] = "Все производители";
  	// ---->>>
  	ksort($marks);
  	ksort($trademarks);
  	$this->_page->Template->assign('trademarks',$trademarks);
  	
  	$mark_ids  =array_keys($marks);
  	$mark_names=array_values($marks);
  	$mark_ids[0] = 0;
  	$mark_names[0] = "Вcе производители";
  	//dump($mark_ids);
  	$this->_page->Template->assign('mark_ids',$mark_ids);
  	$this->_page->Template->assign('mark_names',$mark_names);
  	// get models - no need to.
  	// get types
   	$type=new Socnet_Catalog_Category_List();
    $type->returnAsAssoc(true);
    $types=$type->getList();
    // 
    $type_ids   = array_keys($types);
    $type_names = array_values($types);
    $this->_page->Template->assign('type_ids',$type_ids);
    $this->_page->Template->assign('type_names',$type_names);
  }
  // List like: board/trademark/Ducati  
  else if (empty($model_name) && !empty($sTrademark))
  {
    $mark = new Socnet_Catalog_Trademark_List();
  	$mark->returnAsAssoc(true);
  	$mark->addWhere("id_type_auto=$cat_id");
  	$marks = $mark->getList();
  	
  	$mark_ids  =array_keys($marks);
  	$mark_names=array_values($marks);
  	
  	$mark_ids[0]  =0;
  	$mark_names[0]="Вcе производители";
  	// dump($mark_names);
  	// get models
  	$model = new Socnet_Catalog_Model_List();
  	$model->returnAsAssoc(true);
  	$model->addWhere("id_trademark=$trademark_id");
  	$models = $model->getList();
  	$this->_page->Template->assign('modelsList',$models);
  	
  	$this->_page->Template->assign('trademark_name',$sTrademark);
  	$this->_page->Template->assign('mark_ids',$mark_ids);
  	$this->_page->Template->assign('mark_names',$mark_names);
    // TODO: check valid trademark
    $trademark = new Socnet_Catalog_Trademark_Item($trademark_id);
    $this->_page->Template->assign('tm',$trademark);
    $board->setTrademarkId($trademark_id);
  }
  // List like: board/listbikes/trademark/Ducati/model/  
  else if(!empty($model_name) && !empty($sTrademark))
  {        
    $model_id=$this->getModelId($model_name,$trademark_id,$cat_id);
  	$this->_page->Template->assign("trademark_name",$sTrademark);
  	$this->_page->Template->assign('model_name',$model_name);
  	// $this->listByModel();
  	
  	$mark = new Socnet_Catalog_Trademark_List();
  	$mark->returnAsAssoc(true);
  	$mark->addWhere("id_type_auto=$cat_id");
  	$marks = $mark->getList();
  	
  	$mark_ids  =array_keys($marks);
  	$mark_names=array_values($marks);
  	
  	$mark_ids[0]  =0;
  	$mark_names[0]="Вcе производители";
  	
  	$this->_page->Template->assign('mark_ids',$mark_ids);
  	$this->_page->Template->assign('mark_names',$mark_names);
  	
    $board->setTrademarkId($trademark_id);
    $board->setModelId($model_id);
    // PAGING
    $num_items=$board->getNumItems();
	$this->setPaginator($num_items,$this->oUrl->getCurrentUrl());
    // get models
  	$model = new Socnet_Catalog_Model_List();
  	$model->returnAsAssoc(true);
  	$model->addWhere("id_trademark=$trademark_id");
  	$models = $model->getList();
  	$modelsList = $models;  	
  	
  	$models_ids   =array_keys($models);
  	$models_names =array_values($models);
  	ksort($models);   
  	$models_ids[0]   =0;
  	$models_names[0] ="Все модели";
  	   
  	$this->_page->Template->assign('models_ids',$models_ids);
  	$this->_page->Template->assign('models_names',$models_names);
  	
  	$this->_page->Template->assign('modelsList',$modelsList);
  }
  
  $bikeType = new Socnet_Catalog_Property_Item();
  $bikeType->setId(1);
  $types = $bikeType->getListData();   
  $types[0]="Выберите тип";
  ksort($types);
  
  $type_ids   = array_keys($types);
  $type_names = array_values($types);
  $this->_page->Template->assign('type_ids',$type_ids);
  $this->_page->Template->assign('type_names',$type_names);
  
  $range = range (1950,date('Y'));
  foreach ($range as $year){
  	$years[$year] = $year;
  }
  $this->_page->Template->assign('years',$years);
  $cur_year = date('Y');
  $this->_page->Template->assign('cur_year',$cur_year);
  
  // A LIST OF ADs::
  $boardList=$board->getList();
  $num_items=$board->getNumItems();
  $this->setPaginator($num_items,$this->oUrl->getCurrentUrl());
  
  $this->_page->Template->assign('bikeList',$boardList);
  $this->_page->Template->assign('bodyContent', "board/board.list.bikes.tpl");
?>