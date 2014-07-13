<?php
class Socnet_Catalog_Model_Modification_Item extends Socnet_Data_Entity
{
    private $id;
    private $idModel;
    private $modification;
    private $display;

    private $model;
    private $Properties;
    private $viewMode;

    public function __construct($id = null)
    {
        parent::__construct('catalog__model_modification', array('id' => 'id',
                'id_model' => 'idModel',
                'modification' => 'modification',
                'display' => 'display'
            )
        );

        if (null !== $id) {
            $this->loadByPk($id);
        }

    }

    /**
     * @return unknown
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param unknown_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getIdModel()
    {
        return $this->idModel;
    }

    /**
     * @param unknown_type $idModel
     */
    public function setIdModel($idModel)
    {
        $this->idModel = $idModel;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getModel()
    {
        if (null == $this->model) {
            $this->setModel();
        }
        return $this->model;
    }

    /**
     * @param unknown_type $model
     */
    public function setModel(Socnet_Catalog_Model_Item $model = null)
    {
        if (null == $model) {
            $this->model = new Socnet_Catalog_Model_Item($this->idModel);
        } else {
            $this->model = $model;
        }
        return $this;
    }

    /**
     * @return unknown
     */
    public function getModification()
    {
        return $this->modification;
    }

    /**
     * @param unknown_type $year
     */
    public function setModification($modelModification)
    {
        $this->modification = $modelModification;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getViewMode()
    {
        return $this->viewMode;
    }

    /**
     * @param unknown_type $viewMode
     */
    public function setViewMode($viewMode)
    {
        $this->viewMode = $viewMode;
        return $this;
    }

    /**
     * @return unknown
     */
    public function getProperties()
    {
        if (null == $this->Properties) {
            $this->setProperties();
        }
        return $this->Properties;
    }

    /**
     * @param unknown_type $Properties
     */
    public function setProperties($Properties = null)
    {
        if (null !== $Properties) {
            $this->Properties = $Properties;
        } else
            if (null !== $this->id) {
                $tmpList = new Socnet_Catalog_Model_Property_List();
                //$tmpList->returnAsAssoc(false)->setIdModel($this->id);
                $tmpList->returnAsAssoc(false)->setIdModification($this->id);
                if (null !== $this->getViewMode()) {
                    $func = 'set' . $this->getViewMode() . 'View';
                    $tmpList->$func(true);
                }
                if ($tmpList->getCount() > 0)
                    $this->Properties = $tmpList->getList();
                else $this->Properties = array();
            }
    }

    /**
     * @return unknown
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param unknown_type $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
        return $this;
    }

    public function deleteProperties()
    {
        $where = array(
            $this->_db->quoteInto('id_property != ?', 35),
            $this->_db->quoteInto('id_modification = ?', $this->getId())
        );
        $sql = $this->_db->delete('catalog__model_property', $where);
    }
}

?>
