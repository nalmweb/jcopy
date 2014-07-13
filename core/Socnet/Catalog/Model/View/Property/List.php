<?php
class Socnet_Catalog_Model_View_Property_List extends Socnet_Abstract_List
{
    private $idModelGod;
    private $idProperty;
    private $shortView;
    private $listView;
    private $fullView;
    private $bboardView;

    /**
     * @return unknown
     */
    public function getIdModelGod()
    {
        return $this->idModelGod;
    }

    /**
     * @param unknown_type $idModelGod
     */
    public function setIdModelGod($idModelGod)
    {
        $this->idModelGod = $idModelGod;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getIdProperty()
    {
        return $this->idProperty;
    }

    /**
     * @param unknown_type $idProperty
     */
    public function setIdProperty($idProperty)
    {
        $this->idProperty = $idProperty;
        return $this;
    }


    /**
     * @return unknown
     */
    public function getBboardView()
    {
        return $this->bboardView;
    }

    /**
     * @param unknown_type $bboardView
     */
    public function setBboardView($bboardView = true)
    {
        $this->bboardView = $bboardView;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getFullView()
    {
        return $this->fullView;
    }

    /**
     * @param unknown_type $fullView
     */
    public function setFullView($fullView = true)
    {
        $this->fullView = $fullView;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getListView()
    {
        return $this->listView;
    }

    /**
     * @param unknown_type $listView
     */
    public function setListView($listView = true)
    {
        $this->listView = $listView;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getShortView()
    {
        return $this->shortView;
    }

    /**
     * @param unknown_type $shortView
     */
    public function setShortView($shortView = true)
    {
        $this->shortView = $shortView;
        return $this;
    }

    public function getList()
    {
        $query = $this->_db->select();
        if ($this->isAsAssoc()) {
            $fields = array();
            $fields[] = ($this->getAssocKey() === null) ? 'id' : $this->getAssocKey();
            $fields[] = ($this->getAssocValue() === null) ? 'value' : $this->getAssocValue();
            $query->from(array('cmp' => 'view__catalog_model_property'), $fields);
        } else {
            $query->from(array('cmp' => 'view__catalog_model_property'), 'id');
        }

        if ($this->getWhere()) $query->where($this->getWhere());

        if (null !== $this->getIdModelGod()) {
            $query->where('cmp.id_model_god = ?', $this->getIdModelGod());
        }

        if (null !== $this->getIdProperty()) {
            $query->where('cmp.id_property = ?', $this->getIdProperty());
        }
        if ($this->getBboardView()) {
            $query->where('cmp.bboard_view = 1');
        } else

            if ($this->getListView()) {
                $query->where('cmp.list_view = 1');
            } else

                if ($this->getShortView()) {
                    $query->where('cmp.short_view = 1');
                } else

                    if ($this->getFullView()) {
                        $query->where('cmp.full_view = 1');
                    }

        if ($this->getCurrentPage() !== null && $this->getListSize() !== null) {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        if ($this->getOrder() !== null) {
            $query->order($this->getOrder());
        }
        //print $query->__toString();exit;
        $items = array();
        if ($this->isAsAssoc()) {
            $items = $this->_db->fetchPairs($query);
        } else {
            $items = $this->_db->fetchCol($query);
            foreach ($items as &$item) $item = new Socnet_Catalog_Model_View_Property_Item('id', $item);
        }
        return $items;
    }

    public function getCount()
    {
        $query = $this->_db->select();
        $query->from('catalog__model_property', 'COUNT(*)');
        if (null !== $this->getIdModel()) $query->where('id_model = ?', $this->getIdModel());
        if ($this->getWhere()) $query->where($this->getWhere());
        return $this->_db->fetchOne($query);
    }
}

?>
