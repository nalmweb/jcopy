<?php
 /**
  * марка, модель, год, объем, страна, город, - select 
  * цена, 
  * валюта, 
  * описание, 
  * фото.
  */
   $board=new Socnet_Board_List();
   $board->setCatId(1);
   $board->setOrder('reg_date DESC');
   $board->returnAsAssoc(false);
   $board->setListSize(10)->setCurrentPage(1);
   $boardList=$board->getList();
   
   //--> GET MARKS
   $Trademarks = new Socnet_Catalog_Trademark_List();
   $Trademarks->returnAsAssoc(true);
   $Trademarks->addWhere("id_type_auto=1");//bikes
   $bikeMarks=$Trademarks->getList();
   ksort($bikeMarks);
   $this->_page->Template->assign('bikeMarks',$bikeMarks);
   //<---
   $board->setCatId(2);
   $board->setOrder('reg_date DESC');
   $board->returnAsAssoc(false);
   $board->setListSize(10)->setCurrentPage(1);
   $detailsList=$board->getList();
   
   //--> GET MARKS DETAILS
   $sql = $this->_db->select()->from("board__details_names");
   $detailsTypes  = $this->_db->fetchAll($sql);
   ksort($detailsTypes);
   $this->_page->Template->assign('detailsTypes',$detailsTypes);
   //<--
   $board->setCatId(3);
   $board->setOrder('reg_date DESC');
   $board->returnAsAssoc(false);
   $board->setListSize(10)->setCurrentPage(1);
   $outfitList=$board->getList();
   /*$*/
   $listOutfit = new Socnet_Catalog_Outfit_List();
   $outfitTypes = $listOutfit->getTypes();
   //ksort($outfitTypes);
   $this->_page->Template->assign('outfitTypes',$outfitTypes);
   //dump($boardList);
   $this->_page->Template->assign('bikeList',$boardList);
   $this->_page->Template->assign('detailsList',$detailsList);
   $this->_page->Template->assign('outfitList',$outfitList);
   
// set html elements
/* $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
   $form->accept($renderer);
   $this->_page->Template->assign('formContent', $renderer->toArray());
*/
   $this->_page->Template->assign('bodyContent', 'board/board.index.tpl');
?>
