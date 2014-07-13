<?php
if (! $this->_page->_user->isAuthenticated ()) {
	$this->_redirect ( 'http://' . BASE_HTTP_HOST . '/' );
} elseif (! $this->_page->_user->isAdmin ()) {
	$this->_redirect ( 'http://' . BASE_HTTP_HOST . '/' );
}

$form = new Socnet_Form ('options', 'POST');

if (isset($this->params['options'])) {

	$new = $this->params['options']['new'];
	$newParam = $this->params['optionsParam']['new'];
	unset( $this->params['options']['new']);
	unset( $this->params['optionsParam']['new']);

	if ('' !== $new && '' !== $newParam) {
		$options = new Socnet_Board_Options();
		$options->name = $new;
		$options->status = $newParam;
		$options->create_date = date('Y-m-d H:i:s');
		$options->save ();
		unset ( $options );
	}

  if(sizeof($this->params['options']) > 0) {
		foreach($this->params['options'] as $key => $name) {
		  $options = new Socnet_Board_Options($key);
			if ('' !== trim ( $name )) {
				$options->name = $name;
				$options->status = $this->params['status'][$key];
				$options->save ();
			} else {
				$options->delete ();
			}
      unset ( $options );
		}
	}
}

$options = new Socnet_Board_Options();
$options_array = $options->setOptionsListAssoc();
$this->_page->Template->assign ( 'option', $options_array );
$this->_page->Template->assign('form', $form );
$this->_page->setTitle ( 'Админка::Настройка дополнительных опций в обьявлении' );
$this->_page->Template->assign('menuTab','board');
$this->_page->Template->assign('menuPodTab','options');
$this->_page->Template->assign(array('bodyContent'   => 'admin/board/board.options.tpl'));
?>
