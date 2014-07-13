<?php
class Socnet_Catalog_Trademark_Item extends Socnet_Data_Entity
{
  private $id;
  private $name;
  private $idTypeAuto;
  private $idCountry;
  private $idLogo;

  private $typeAuto;
  private $Country;
  private $Logo;

  public function __construct($id = null)
  {
    parent::__construct('catalog__trademark', array('id' => 'id',
      'name' => 'name',
      'id_type_auto' => "idTypeAuto",
      'id_country' => 'idCountry',
      'logo_id' => 'idLogo'));
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
  public function getName()
  {
    return $this->name;
  }

  public function getUrlName()
  {
    return str_replace(" ", "_", strtolower($this->name));
  }

  /**
   * @return unknown
   */
  public function getCountry()
  {
    if (null == $this->Country) {
      $this->setCountry();
    }
    return $this->country;
  }

  /**
   * @param unknown_type $Country
   */
  public function setCountry()
  {
    if (null !== $this->idCountry) {
      $this->country = new Socnet_Location_Country($this->getIdCountry());
    }
  }

  /**
   * @return unknown
   */
  public function getIdCountry()
  {
    return $this->idCountry;
  }

  /**
   * @param unknown_type $idCountry
   */
  public function setIdCountry($idCountry)
  {
    $this->idCountry = $idCountry;
    return $this;
  }

  /**
   * @param unknown_type $name
   */
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getIdTypeAuto()
  {
    return $this->idTypeAuto;
  }

  /**
   * @param unknown_type $idTypeAuto
   */
  public function setIdTypeAuto($idTypeAuto)
  {
    $this->idTypeAuto = $idTypeAuto;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getTypeAuto()
  {
    if (null == $this->typeAuto) {
      $this->setTypeAuto($this->getIdTypeAuto());
    }

    return $this->typeAuto;
  }

  /**
   * @param unknown_type $typeAuto
   */
  public function setTypeAuto($typeAuto)
  {
    $this->typeAuto = new Socnet_Catalog_Type_Item($typeAuto);
  }

  /**
   * @return unknown
   */
  public function getIdLogo()
  {
    if($this->idLogo == null)
      $this->setIdLogo();
    return $this->idLogo;
  }

  /**
   * @param unknown_type $idLogo
   */
  public function setIdLogo($idLogo = 0)
  {
    if ($idLogo > 0)
      $this->idLogo = $idLogo;
    else
      $this->idLogo = 0;
    return $this;
  }

  /**
   * @return unknown
   */
  public function getLogo()
  {
    if (null == $this->Logo) {
      $this->setLogo();
    }
    return $this->Logo;
  }

  /**
   * @param unknown_type $Logo
   */
  public function setLogo()
  {
    if (null !== $this->idLogo) {
      $this->Logo = new Socnet_Catalog_Metadata_Item($this->idLogo);
    }
    //print_f($this->Logo);
  }
}

?>
