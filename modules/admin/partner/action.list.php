<?

if (isset($this->params['trueDel']) && is_numeric($this->params['partnerId'])) {

  $partner = new Socnet_Partner_Item();
  $partner->delete($this->params['partnerId']);

  $this->_page->Template->assign('success', 'Каталог успешно удален');

}elseif(isset($this->params['falseDel'])){
  $this->_page->Template->assign('errors', 'Удаление отменено');
}

$partners = new Socnet_Partner_List();
$partners->returnAsAssoc(false);

$paginator = new Socnet_Paginator_Item('http://' . BASE_HTTP_HOST . '/admin/partnerList/', $partners->getCount());
$pgr = $paginator->getInfo();
$this->_page->Template->assign('pgr', $pgr);

$partnerArray = $partners->getList($pgr['current']);


$this->_page->Template->assign('partner', $partnerArray );


//$this->_page->Template->assign('arr', array(
//   'black'
//  ,'blue'
//  ,'brown_dark'
//  ,'brown_light'
//  ,'cyan'
//  ,'gray_dark'
//  ,'gray_light'
//  ,'green'
//  ,'magenta'
//  ,'orange'
//  ,'red'
//  ,'tan'
//  ,'yellow'
//  ,'white'
//) );


$this->_page->setTitle('Админка::Список каталогов');
//$this->_page->Template->assign('formContent', $renderer->toArray());

$this->_page->Template->assign(array('bodyContent'   => 'admin/partner/list.tpl'));

$this->_page->Template->assign('menuPodTab','partnerlist');
$this->_page->Template->assign('menuTab','partner');