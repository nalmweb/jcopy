<?php
$form = new Socnet_QuickForm_Page('indexSearch', 'post', "/users/search/",true);
$elements = array(  'nikname'   => 'Ник:',
                    'street'    => 'Улица:',
                    'metro'     => 'Метро:',
                    'country'   => 'Страна:',
                    'city'      => 'Город:',
);
foreach ($elements as $key => $value) {
    $form->addElement('text', $key, $value, array('style' => 'width:180px;'));
    $form->addElement('advcheckbox', "strict_$key", '','строгое соответствие.');
    $form->applyFilter($key,'trim');
}
$form->addElement('select','gender', 'Пол:',array(''=>'','male'=>"Мужчина",'female'=>"Женщина"));
$form->addElement(new Socnet_QuickForm_submit('submitForm', 'Искать', 'gray'));
$renderer = new Socnet_QuickForm_Renderer_ArraySmarty($page->Template);
$form->accept($renderer);

if (isset($this->_session->searches))
    $searches = $this->_session->searches;
else $searches = null;

if ($form->validate() || isset($this->params['page'])) {
    $perPage = 2;
    $submittedData = $form->getSubmitValues();
    if (!empty($submittedData)) {
        $values = $form->getSubmitValues();
    } elseif ($searches !== null) {
        $values = $searches;
    } else $values = null;

    if ($values !== null) {
        $SQL = "SELECT * FROM `view__users_search` ";
        $conditions = '';
        foreach ($elements as $key => $value) {
            if ($values[$key] == 'Не известно') $values[$key] = '';
            if ($values[$key]) {
                if ($values["strict_$key"] == 1) {
                    $conditions .= " AND $key = '{$values[$key]}'";
                } else {
                    $conditions .= " AND $key LIKE '%{$values[$key]}%'";
                }
            }
        }
        if ($values['gender'] != '') $conditions .= " AND gender = '{$values['gender']}'";
        if (strlen($conditions) > 0)
        $conditions = "WHERE ".substr($conditions,4);
        $SQL .= $conditions;
        $result = $this->_db->fetchAll($SQL);
    }
    if (isset($result)) {
        if (count($result) > $perPage) {
            $page = isset($this->params['page']) ? $this->params['page'] - 1 : 0;
            $limit = " LIMIT ". ($page*$perPage). ", ". ($page*$perPage+$perPage);
            $pagging = new Socnet_Common_Paging(count($result),$perPage,"/users/search");
            $this->_page->Template->assign('pagging', $pagging->makeSearchPagging($page + 1));
            $SQL .= $limit;
            $result = $this->_db->fetchAll($SQL);
        }
        $this->_page->Template->assign('searchResult', $result);
        $searches = $values;
    } else $this->_page->Template->assign('noResult', true);
}
$this->_session->searches = $searches;
$this->_page->Template->assign('formContent', $renderer->toArray());
$this->_page->Template->assign('bodyContent', 'search/index.tpl');
?>