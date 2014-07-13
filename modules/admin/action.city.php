<?php

    $form = new Socnet_QuickForm_Page('cities', 'POST', 'http://'.BASE_HTTP_HOST.'/admin/cities/', false);

    $countries = new Socnet_Location();
    $countries_array = $countries->getCountriesListAssoc();
    $form->addElement($f2 = new HTML_QuickForm_select('country', 'Страна:', $countries_array, array('style' => 'width:180px;')));

    $form->addElement('text','name', 'Город:', array('style' => 'width:180px;', 'id' => 'country'));
    $form->applyFilter('name','trim');
    $form->addElement($f5 = new Socnet_QuickForm_submit('save', 'Добавить', 'gray'));
    $form->addFormRule('uniqueCity');

    if ($form->validate()) {
        $fields = $form->getSubmitValues();
        $oCity = new Socnet_Location_City();
        $oCity->countryId = $fields['country'];
        $oCity->name = $fields['name'];
        $oCity->status = "system";
        $oCity->save();
        //print_f($_POST);
    }else
      $this->_page->Template->assign('errors', $form->getElementError('name'));

    $renderer = new Socnet_QuickForm_Renderer_ArraySmarty($this->_page->Template);
    $form->accept($renderer);


    $paginator = new Socnet_Paginator_Item('http://' . BASE_HTTP_HOST . '/admin/cities/', $countries->getCityCount());
    $pgr = $paginator->getInfo();
    $this->_page->Template->assign('pgr', $pgr);

    $city_array = $countries->getCityListAssoc($pgr['current']);
    $this->_page->Template->assign('city_array', $city_array);

    $this->_page->setTitle('Админка :: Города');
    $this->_page->Template->assign('formContent', $renderer->toArray());
    $this->_page->Template->assign(array('bodyContent'   => 'admin/city.tpl'));
    $this->_page->Template->assign('menuPodTab','city');

    function uniqueCity($fields){
        if (true === Socnet_Location_City::isCityExists($fields)){
            return array('name' => "Город \"{$fields['name']}\" в базе уже существует.");
        }
        return true;
    }

?>
