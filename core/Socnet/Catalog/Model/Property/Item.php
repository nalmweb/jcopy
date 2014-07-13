<?php

class Socnet_Catalog_Model_Property_Item extends Socnet_Data_Entity {
  private $id;
  private $idProperty;
  private $idModel;
  private $idModification;
  private $value;
  private $valuesList;
  private $valuesListData;
  private $flagDisc;
  private $property;
  private $idModelGod;
  private $PropertyValueList;

  function __construct($id = null) {
    parent::__construct('catalog__model_property', array('id' => 'id',
        'id_property' => 'idProperty',
        'id_model' => 'idModel',
        'id_modification' => 'idModification',
        'value' => 'value',
        'value_list' => 'valuesList',
        'flag_disc' => 'flagDisc',
      )
    );

    if (null !== $id) {
      $this->loadByPk($id);
    }
  }

  /**
   * @return unknown
   */
  public function getFlagDisc() {
    return $this->flagDisc;
  }

  /**
   * @param unknown_type $flagDisc
   */
  public function setFlagDisc($flagDisc) {
    $this->flagDisc = $flagDisc;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param unknown_type $id
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdModel() {
    return $this->idModel;
  }

  /**
   * @param unknown_type $idModel
   */
  public function setIdModel($idModel) {
    $this->idModel = $idModel;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdModification() {
    return $this->idModification;
  }

  /**
   * @param unknown_type $idModification
   */
  public function setIdModification($idModification) {
    $this->idModification = $idModification;
    return $this;
  }

  public function setIdModelGod($idModelGod) {
    $this->idModelGod = $idModelGod;
  }

  public function getIdModelGod() {
    return $this->idModelGod;
  }

  /**
   * @return unknown
   */
  public function getIdProperty() {
    return $this->idProperty;
  }

  /**
   * @param unknown_type $idProperty
   */
  public function setIdProperty($idProperty) {
    $this->idProperty = $idProperty;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @param unknown_type $value
   */
  public function setValue($value) {
    $this->value = $value;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getValuesList() {
    return $this->valuesList;
  }

  /**
   * @param unknown_type $valuesList
   */
  public function setValuesList($valuesList) {
    $this->valuesList = $valuesList;
    return $this;
  }

  public function getValuesListData() {
    if (null == $this->valuesListData) {
      $this->setValuesListData();
    }
    return $this->valuesListData;
  }


  public function setValuesListData() {
    if (null !== $this->valuesList) {
      $this->valuesListData = new Socnet_Catalog_Model_Property_ListData($this->valuesList);
    } elseif ($this->getProperty()->getIdTypeProperty() == 3) {
      $this->valuesListData = new Socnet_Catalog_ListData_Item();
      $this->valuesListData->setIdProperty($this->getIdProperty());
    }
    return $this;
  }

  /**
   * @return unknown
   */
  public function getProperty() {
    if (null == $this->property) {
      $this->setProperty();
    }
    return $this->property;
  }

  /**
   * @param unknown_type $Properties
   */
  public function setProperty() {
    if (null !== $this->idProperty) {
      $this->property = new Socnet_Catalog_Property_Item($this->getIdProperty());
    }
  }

  public function getPropertyValueById($idProperty) {
    $sql = $this->_db->select()->from("catalog__model_property")
      ->where("id_property = ?", $idProperty);

    if ($this->idModelGod) {
      $sql->where("id_model_god=?", $this->idModelGod);
    }elseif ($this->idModification) {
      $sql->where("id_modification=?", $this->idModification);
    }elseif ($this->idModel) {
      $sql->where("id_model=?", $this->idModel);
    }

    $rs = $this->_db->fetchAll($sql);
    if (!empty($rs)) {

      if (!empty($rs[0]))
        return $rs[0]['value'];
      else
        return false;
    }
    return false;
  }

  public function setPropertyValueList($array) {
    $this->PropertyValueList = $array;
    return true;
  }

  public function checkPropertyValueList($int, $field = false, $ID = false) {
    $valueList = $this->getPropertyValueList(false, $field, $ID);
    if (isset($valueList[$int]) && $valueList[$int] == 1)
      return true;
    else
      return false;
  }

  /*
  * $idProperty
  * $modelGodID
  */
  public function getPropertyValueList($idProperty = false, $field = false, $ID = false) {

    if (is_array($this->PropertyValueList))
      return $this->PropertyValueList;

    $sql = $this->_db->select()->from("catalog__model_property", array('id_property', 'value_list'));

    if ($ID && $field)
      $sql->where($field . "=?", $ID);
    else {
      if ($idProperty)
        $sql->where("id_property = ?", $idProperty);

      if ($this->idModelGod) {
        $sql->where("id_model_god=?", $this->idModelGod);
      } elseif ($this->idModel) {
        $sql->where("id_model=?", $this->idModel);
      } elseif ($this->idModification) {
        $sql->where("id_modification=?", $this->idModification);
      }

    }

    $rs = $this->_db->fetchAll($sql);
    if (!empty($rs) && is_array($rs)) {
      $output = array();
      foreach ($rs as $value)
        $output[$value['value_list']] = true;

      $this->PropertyValueList = $output;
      return $output;
    }
    return false;
  }

  /*
  * $idProperty
  * $modelGodID
  */
  public function getPropertyValueListName($idProperty = false, $modelGodID = false) {

    if(is_array($this->PropertyValueList) && (!$idProperty || !$modelGodID))
      return $this->PropertyValueList;

    $sql = $this->_db->select()->from("view__catalog_list_property", array('id_property', 'id', 'value_list', 'name'));

    if ($idProperty)
      $sql->where("id_property = ?", $idProperty);

    if ($this->idModelGod) {
      $sql->where("id_model_god=?", $this->idModelGod);
    } elseif ($modelGodID)
      $sql->where("id_model_god=?", $modelGodID);

    if($this->idModification){
      $sql->where("id_modification=?",$this->idModification);
    }

    $rs = $this->_db->fetchAll($sql);
    if (!empty($rs) && is_array($rs)) {
      $output = array();
      foreach ($rs as $value)
        $output[$value['id']] = $value['name'];

      $this->PropertyValueList = $output;
      return $output;
    }
    return false;
  }

}

?>