<?php
if (! $this->_page->_user->isAuthenticated ()) {
	$this->_redirect ( 'http://' . BASE_HTTP_HOST . '/' );
} elseif (! $this->_page->_user->isAdmin ()) {
	$this->_redirect ( 'http://' . BASE_HTTP_HOST . '/' );
}

$form = new Socnet_Form ('price', 'POST');

if (isset($this->params['price'])) {

	$new = $this->params['price']['new'];
	$newParam = $this->params['priceParam']['new'];
	unset( $this->params['price']['new']);
	unset( $this->params['priceParam']['new']);

	if ('' !== $new && '' !== $newParam) {
		$price = new Socnet_Board_Price();
		$price->name = $new;
		$price->status = $newParam;
		$price->create_date = date('Y-m-d H:i:s');
		$price->save();
		unset($price );
	}

  if(sizeof($this->params['price']) > 0) {
		foreach($this->params['price'] as $key => $name) {
		  $price = new Socnet_Board_Price($key);
			if ('' !== trim ( $name )) {
				$price->name = $name;
				$price->status = $this->params['status'][$key];
				$price->save ();
			} else {
				$price->delete ();
			}
      unset ( $price );
		}
	}
}

$price = new Socnet_Board_Price();
$price_array = $price->setPriceListAssoc();
$this->_page->Template->assign ( 'price', $price_array );
$this->_page->Template->assign('form', $form );
$this->_page->Template->assign('menuTab','board');
$this->_page->Template->assign('menuPodTab','price');
$this->_page->setTitle ( 'Админка::Настройка дополнительных опций в обьявлении' );
$this->_page->Template->assign(array('bodyContent'   => 'admin/board/board.price.tpl'));
?>
