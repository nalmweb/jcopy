<?php
/*
 *{----->>>]|-=>[x]Created on 14.12.2007
 */
$cat_id = 0;
$item_id = intval(Socnet::$urlParams[4]);
$cat = Socnet::$urlParams[3];

// dump($_SERVER);
$self = "http://" . BASE_HTTP_HOST . $_SERVER['QUERY_STRING'];
$this->_page->Template->assign('self', $self);
// echo $self;

switch ($cat)
{
  //case 'details': $cat_id=2; break;
  case 'auto' :
    $cat_id = 1;
    break;
  default:
    $this->_redirect("/board/listauto/");
    break;
}

// $cats = array("1"=>'Легковые автомобили',"2"=>"Запчасти","3"=>"Экипировка");
$cats = array("1" => 'Легковые автомобили');
/*
$sql=$this->_db->select()->from("catalog__outfit","title")->where("cid=?",$item_id);
echo "".$sql->__toString();
$res=$this->_db->fetchCol($sql);
dump($res);
*/
/**
[0] =>
[1] => board
[2] => item
[3] => bikes|details|outfit
[4] => 4.html
 */
// dump($this->crumbs);
// dump(Socnet::$urlParams);
if (is_int($item_id)) {
  $item = new Socnet_Board_Item($cat_id, $item_id);

  //echo "num=".$item->getNumAds();
  //echo "can_add=[".$item->canAdd();

  if (!$item->bExists($item_id)) {
    $this->setMessage(NOT_FOUND);
    //echo "=".$this->getMessage();
    $this->_redirect("/board/info/");
  }
  $item->getType();
  $photos = $item->getImageList();

  $user_id = $item->user_id;
  $user = new Socnet_User('id', $user_id);
  // dump($item);
  // exit;
  $this->_page->Template->assign("ad", $item);
  $this->_page->Template->assign("photos", $photos);
  $this->_page->Template->assign("adUser", $user);
  $users = '';

  $isOwner = 0;
  if ($isOwner = $item->isOwner()) {
    $this->_page->Template->assign('isOwner', $isOwner);
  }
  // echo " mark  = ".$item->mark_id;
  // это про мотоциклы - кто на чем ездит.
  if ($cat_id == 1) {
    /*$collection = new Socnet_User_Collection();
  $users = $collection->getUsersByBike($item->model_id);*/
    // echo "model = ".$item->model_id;
    $oItem = new Socnet_Catalog_Model_View_Item($item->model_id, 'id');
    $oItem->setIdModel($item->model_id);
    // exit;
    $users = $oItem->getRelatedUsers();
    // dump($users);
    $this->_page->Template->assign('usersList', $users);
  }
  //dump($item->imageList);
  $this->_page->Template->assign('crumbs', $this->crumbs);
  // echo "cat_id=$cat_id";

  if ($cat_id == 1)
    $this->_page->Template->assign('bodyContent', 'board/board.item_bike.tpl');

}
else
{
  // IN URL not a number
  $this->_page->Template->assign('bodyContent', 'board/board.err_url_format.tpl');
}
?>
