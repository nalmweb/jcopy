<?

$board = new Socnet_Board_List();
$board->setCatId(1);

$paginator = new Socnet_Paginator_Item('http://' . BASE_HTTP_HOST . '/cp/boardCars/', $board->getCount());
$pgr = $paginator->getInfo();
$this->_page->Template->assign('pgr', $pgr);

$board->setOrder('reg_date DESC');
$board->returnAsAssoc(false);
$board->setCurrentPage($pgr['current']);
//print_f($board->getList());
$this->_page->Template->assign('cars_array', $board->getList());

$this->_page->Template->assign('bodyContent', 'cp/board/cars.tpl');
$this->_page->Template->assign('menuTab','board');
$this->_page->Template->assign('menuPodTab','cars');