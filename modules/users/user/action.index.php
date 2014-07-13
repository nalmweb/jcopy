<?php


$this->_page->Xajax->registerUriFunction("changeAdStatus","/ajax/changeAdStatus/");

$board=new Socnet_Board_List();
//
$board->setUserId($_SESSION['user_id']);
$board->setCatId(BIKES);
$board->setIsActive(null);

$board->setOrder('is_active DESC');
$board->returnAsAssoc(false);
$board->setListSize(15)->setCurrentPage(1);
$boardList=$board->getList();
//dump($boardList);

////details:
//$board->setCatId(DETAILS);
//$board->setOrder('is_active DESC');
//$board->returnAsAssoc(false);
//$board->setListSize(10)->setCurrentPage(1);
//$detailsList=$board->getList();

// lists
$this->_page->Template->assign('bikeList',$boardList);
//$this->_page->Template->assign('detailsList',$detailsList);

$this->_page->Template->assign('bodyContent', 'users/index.tpl');