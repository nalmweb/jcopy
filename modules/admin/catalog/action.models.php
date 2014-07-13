<?php
  if (!$this->_page->_user->isAuthenticated()) {
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  } elseif (!$this->_page->_user->isAdmin()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
  }

   $this->_page->Xajax->registerUriFunction("selectTrademark","/admin/selectTrademark/");
   $this->_page->Xajax->registerUriFunction("setVisibleModification","/admin/setVisibleModification/");

   $form = new Socnet_Form('selectTrademark', "POST");

   $markList = new Socnet_Catalog_Trademark_List();
   $markList->setIdTypeAuto( 1 );
   $markList->returnAsAssoc(true);
   $markList->setOrder('catalog__trademark.name ASC');
   $marks = $markList->getList();
   $marks[0] = "[Выберите производителя]";
   ksort($marks);
   $this->_page->Template->assign('marks', $marks );

   if ( isset( $this->params['markId'])) {
       if ( isset($this->params['models']) ) {
           $new = $this->params['models']['new']; unset($this->params['models']['new']);
           if ( '' !== $new ) {
                $model = new Socnet_Catalog_Model_Item( );
                $model->setIdTrademark( $this->params['markId'] );
                $model->setName( $new );
                $model->save();
                unset($model);
           }
           if ( sizeof($this->params['models']) > 0 ) {
               foreach ( $this->params['models'] as $key => $name ) {
                   if ( '' !== trim( $name ) ) {
                       $model = new Socnet_Catalog_Model_Item( $key );
                       $model->setIdTrademark( $this->params['markId'] );
                       $model->setName( $name );
                       $model->save();
                   } else {
                       $model = new Socnet_Catalog_Model_Item( $key );
                       $model->delete();
                   }
                   unset($model);
               }
           }
       }

        $model = new Socnet_Catalog_Model_List($this->params['markId']);
        $model->returnAsAssoc(false);
        $model->setOrder('name ASC');
        $models = $model->getList();

        $this->_page->Template->assign('models', $models );
        $this->_page->Template->assign('markId', $this->params['markId'] );
   }


   $this->_page->Template->assign('form', $form);
   $this->_page->Template->assign('bodyContent', 'admin/catalog/models.tpl');
   $this->_page->Template->assign('menuTab','catalog');
   $this->_page->Template->assign('menuPodTab','models');
?>