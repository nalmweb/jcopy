<?php
// delete photo
// upload a new one.

if(!isValidSession())
   $this->_redirect("/");
   
$objResponse = new xajaxResponse();
// check Owner
// $module=$Socnet::
$table_name = Socnet_Photo_Config::getPhotoTableById($photos_type_id);
Socnet_Photo_Config::setTypeId($photos_type_id);

//$objResponse->addAlert($table_name." typ=e".$photos_type_id);
// get table name
if(empty($table_name)){
   	$objResponse->addAlert("Изменение фото.Ошибка в запросе!");
   	return $objResponse;
}

 $cat_id = isset($cat_id)?$cat_id:0;
 // check owner!
 $isOwner = false; 
 
 if ( $photos_type_id == 23424 || $photos_type_id == 23425 || $photos_type_id == 23426 )
 {
 	 $board   = new Socnet_Board_Item($cat_id,$item_id);
 	 $isOwner = $board->isOwner();
 }
 else
 { 
     $isOwner =Socnet_Photo_Config::isOwner($table_name,$item_id);
 } 
 
 if(!$isOwner){
	    $objResponse->addAlert("Хулиганите? Нельзя изменять чужое фото.");
   	  return $objResponse;
 }
//$tm = new Socnet_Catalog_Trademark_Item( $markId );
//$this->_page->Template->assign('tm', $tm );
/**
@TODO:action - set action by type!!!
 board: users/adsEdit/cat/1/item/81/
 news:	users/editNews/id/value/
 ugon:  users/editUgon/id/value/
*/
//$cat_id = empty($cat_id)?0:$cat_id;
// @TODO: change to a more secure way.

$action = Socnet_Photo_Config::getAction($item_id,$cat_id);
 
//$action ="/users/editAds/cat/1/item/25/";
 
// $objResponse->addAlert($action);
// как прописать сюда нужный action?
// fdump($action);

$this->_page->Template->assign('upload_action',$action);
$this->_page->Template->assign('item_id',$item_id);
$this->_page->Template->assign('photo_id',$photo_id);
$this->_page->Template->assign('photos_type',$photos_type_id);

// SET PHOTOS TYPE::
$content=$this->_page->Template->getContents('common/common.changePhoto.tpl');
//$objResponse ->addAlert($content);
//fdump($content);
$objResponse->addAssign("ajaxContent", "innerHTML",$content);
$objResponse->addScript("openMyDialog('ajaxContent');");
$objResponse->addScript('initSWFU();');
?>