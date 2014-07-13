<?php
    $items_per_page = 20;
	$this->params['page'] = (isset($this->params['page']))? $this->params['page'] : 1;

    $listsList = $this->currentUser->artifacts->getListsList($this->params['page'], $items_per_page);
    $listsCount = $this->currentUser->artifacts->getListsCount();

    $this->_page->Template->assign('listsList', $listsList);
    $this->_page->Template->assign('listsCount', $listsCount);

	// paging
	if ( USE_USER_PATH ) {
	   $paging_url = $this->currentUser->user_adv_path.$this->_page->Locale.'/lists';
	} else {
	   $paging_url = 'http://'.BASE_HTTP_HOST.'/'.$this->_page->Locale.'/users/lists';
	}
	$P = new Socnet_Common_Paging($listsCount, $items_per_page, $paging_url);
	$this->_page->Template->assign('paging', $P->makePaging($this->params['page']));

    $this->_page->Template->assign('bodyContent', 'users/lists.tpl');