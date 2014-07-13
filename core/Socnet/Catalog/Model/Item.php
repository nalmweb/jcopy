<?php
class Socnet_Catalog_Model_Item extends Socnet_Data_Entity {
  private $id;
  private $name;
  private $idTrademark;
  private $idPrimaryImage;
  private $description;
  private $display;

  private $Trademark;
  //private $trademark;
  private $Category;
  private $idCategory;
  private $primaryImage;

  private $Properties;
  private $viewMode;

  public function __construct($id = null) {
    parent::__construct('catalog__model', array('id' => 'id',
      'id_trademark' => 'idTrademark',
      'primary_image' => 'idPrimaryImage',
      'description' => 'description',
      'name' => 'name',
      'display' => 'display'
    ));

    if (null !== $id) {
      $this->loadByPk($id);
    }
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
   * @return mixed
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @param unknown_type $description
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdCategory() {
    return $this->idCategory;
  }

  /**
   * @param unknown_type $idCategory
   */
  public function setIdCategory($idCategory) {
    $this->idCategory = $idCategory;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdPrimaryImage() {
    return $this->idPrimaryImage;
  }

  /**
   * @param $idPrimaryImage
   * @return Socnet_Catalog_Model_Item
   */
  public function setIdPrimaryImage($idPrimaryImage) {
    $this->idPrimaryImage = $idPrimaryImage;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdTrademark() {
    return $this->idTrademark;
  }

  /**
   * @param unknown_type $idTrdemark
   */
  public function setIdTrademark($idTrademark) {
    $this->idTrademark = $idTrademark;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getPrimaryImage() {
    if (null == $this->primaryImage) {
      $this->setPrimaryImage();
    }
    return $this->primaryImage;
  }

  /**
   * @param unknown_type $primaryImage
   */
  public function setPrimaryImage() {
    if (null !== $this->idPrimaryImage) {
      $this->primaryImage = new Socnet_Catalog_Metadata_Item($this->idPrimaryImage);
    }
  }

  /**
   * @return unknown
   */
  public function getTrademark() {
    if (null == $this->Trademark) {
      $this->setTrademark();
    }
    return $this->Trademark;
  }

  /**
   * @param unknown_type $Trademark
   */
  public function setTrademark(Socnet_Catalog_Trademark_Item $trademark = null) {
    if (null == $trademark) {
      $this->Trademark = new Socnet_Catalog_Trademark_Item($this->idTrademark);
    } else {
      $this->Trademark = $trademark;
    }
    return $this;
  }

  /**
   * @return unknown
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param unknown_type $name
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getDisplay() {
    return $this->display;
  }

  /**
   * @param unknown_type $display
   */
  public function setDisplay($display) {
    $this->display = $display;
    return $this;
  }

  /**
   * @return unknown

   */

  public function getProperties() {
    if (null == $this->Properties) {
      $this->setProperties();
    }
    return $this->Properties;
  }

  /**
   * @param unknown_type $Properties

   */

  public function setProperties($Properties = null) {
    if (null !== $Properties) {
      $this->Properties = $Properties;
    } else
      if (null !== $this->id) {
        $tmpList = new Socnet_Catalog_Model_Property_List();
        $tmpList->returnAsAssoc(false)->setIdModel($this->id);
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
  public function getViewMode() {
    return $this->viewMode;
  }

  /**
   * @param unknown_type $viewMode

   */
  public function setViewMode($viewMode) {
    $this->viewMode = $viewMode;
    return $this;
  }

  public function getPhoto() {
    if (null == $this->Photo) {
      $this->setPhoto();
    }
    return $this->Photo;
  }

  public function setPhoto() {
    if (null !== $this->idPhoto) {
      $this->Photo = new Socnet_Catalog_Metadata_Item($this->idPhoto);
    }
  }

  /**
   * @return unknown

   */
  public function getIdPhoto() {
    return $this->idPhoto;
  }

  /**
   * @param unknown_type $idPhoto

   */

  public function setIdPhoto($idPhoto) {
    $this->idPhoto = $idPhoto;
    return $this;
  }

  public function getPhotos() {
    if (null == $this->Photos) {
      $this->setPhotos();
    }
    return $this->Photos;
  }


  public function setPhotos() {
    $query = $this->_db->select();
    $query->from('catalog__model_property', 'value');
    $query->where('id_property = ?', 35);
    $query->where('id_model_god = ?', $this->id);
    $items = $this->_db->fetchCol($query);

    if (sizeof($items) > 0) {
      foreach ($items as &$item) $item = new Socnet_Catalog_Metadata_Item($item);
    }

    $this->Photos = $items;
    return $this;
  }


  public function getYears() {
    $modelYears = new Socnet_Catalog_Model_Year_List();
    $modelYears->setIdModel($this->id);
    $modelYears->returnAsAssoc()->setOrder('god DESC');
    return $modelYears->getList();
  }

  public function deleteProperties() {
    $where = $this->_db->quoteInto('id_model = ?', $this->getId());
    $sql = $this->_db->delete('catalog__model_property', $where);
  }

  public function getUrlName() {
    return str_replace(" ", "_", strtolower($this->name));
  }
}

?>
