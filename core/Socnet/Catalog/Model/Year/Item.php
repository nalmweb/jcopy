<?php
class Socnet_Catalog_Model_Year_Item extends Socnet_Data_Entity
{
  private $id;
  private $idModel;
  private $year;
  private $idPhoto;
  private $display;
  private $idModification;

  private $model;
  private $Properties;

  public function __construct($id = null)
  {
    parent::__construct('catalog__model_god', array('id' => 'id',
        'id_model' => 'idModel',
        'god' => 'year',
        'id_photo' => 'idPhoto',
        'display' => 'display',
        'modification_id' => 'idModification'
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
  public function getYear()
  {
    return $this->year;
  }

  /**
   * @param unknown_type $year
   */
  public function setYear($year)
  {
    $this->year = $year;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdModification()
  {
    return $this->idModification;
  }

  /**
   * @param unknown_type $idModification
   */
  public function setIdModification($idModification)
  {
    $this->idModification = $idModification;
    return $this;
  }  
  
  /**
   * @return unknown
   */
  public function getIdPhoto()
  {
    return $this->idPhoto;
  }

  /**
   * @param unknown_type $idPhoto
   */
  public function setIdPhoto($idPhoto)
  {
    $this->idPhoto = $idPhoto;
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
        $tmpList = new Socnet_Catalog_Model_Year_Property_List();

        $tmpList->returnAsAssoc(false)->setIdModelGod($this->id);
        if ($tmpList->getCount() > 0)
          $this->Properties = $tmpList->getList();
        else $this->Properties = array();
      }
  }

  /**
   * @return unknown
   */
  public function getCategory()
  {
    $tmpList = new Socnet_Catalog_Model_Year_Property_List();

    $tmpList->returnAsAssoc(false)->setIdModelGod($this->id)->setIdProperty(1);
    $PropertyObj = $tmpList->getList();
    if ($PropertyObj) {
      $valueList = $PropertyObj[0]->getValuesListData();
      return $valueList;
    } else return null;
  }

  public function deleteProperties()
  {
    $where = array(
      $this->_db->quoteInto('id_property != ?', 35),
      $this->_db->quoteInto('id_model_god = ?', $this->getId())
    );
    $sql = $this->_db->delete('catalog__model_property', $where);
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

  public function getTrademark()
  {
    return $this->getModel()->getTrademark();
  }
}

?>
