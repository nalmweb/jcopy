<?

$form = new Socnet_QuickForm_Page('partner', 'post', '/admin/partnerList/', true);
$form->addElement('hidden','partnerId', '', array('style' => 'width: 400px'));

if(is_numeric($this->params['id'])){

  if (false === Socnet_Partner_List::isIdPartnerExists($this->params['id'])){
    $this->_page->Template->assign('errors', 'Такого каталога в базе не существует');
  }else{
    $partner = new Socnet_Partner_Item('id', $this->params['id']);
    $this->_page->Template->assign('partner', $partner);
  }
}else{
  $this->_page->Template->assign('errors', 'Такого каталога в базе не существует');
}

$this->_page->setTitle('Админка::Удалить каталог');

$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
$form->accept($renderer);
$this->_page->Template->assign('formContent', $renderer->toArray());

$this->_page->Template->assign(array('bodyContent'   => 'admin/partner/delete.tpl'));

$this->_page->Template->assign('menuPodTab','partner');
$this->_page->Template->assign('menuTab','partner');


function issetPartner($fields){
  if (false === Socnet_Partner_List::isIdPartnerExists($fields['partnerId'])){
    return array('partnerId' => "Такого каталога в базе не существует");
  }
  return true;
}