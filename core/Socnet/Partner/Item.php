<?
/*
 * Created on 09.02.2012
 * Slauta R.
 */

class Socnet_Partner_Item extends Socnet_Data_Entity {
  /**
   * @var
   */
  protected $id;

  /**
   * @var
   */
  protected $name;

  /**
   * @var
   */
  protected $countryId;

  /**
   * @var
   */
  protected $cityId;

  /**
   * @var
   */
  protected $longitude;

  /**
   * @var
   */
  protected $latitude;

  /**
   * @var
   */
  protected $siteUrl;

  /**
   * @var
   */
  protected $passwordKey;

  /**
   * @var
   */
  protected $description;

  /**
   * @var
   */
  protected $unique;

  /**
   * @var
   */
  protected $price;

  /**
   * @var
   */
  protected $penalty;

  /**
   * @var
   */
  protected $information;

  /**
   * @var
   */
  protected $minDay;

  /**
   * @var
   */
  protected $shortNumber;

  /**
   * @var
   */
  protected $customId;

  /**
   * @var
   */
  protected $updateTime;

  /**
   * @var
   */
  private $Country;

  /**
   * @var
   */
  private $City;

  /**
   * @param null $key
   * @param null $val
   */
  public function __construct($key = null, $val = null) {

    parent::__construct('partner__catalog', array(
        'id' => 'id',
        'name' => 'name',
        'country_id' => 'countryId',
        'city_id' => 'cityId',
        'longitude' => 'longitude',
        'latitude' => 'latitude',
        'site_url' => 'siteUrl',
        'password_key' => 'passwordKey',
        'description' => 'description',
        'unique' => 'unique',
        'price' => 'price',
        'penalty' => 'penalty',
        'information' => 'information',
        'min_day' => 'minDay',
        'short_number' => 'shortNumber',
        'custom_id' => 'customId',
        'update_time' => 'updateTime'
      )
    );

    if ($key !== null) {
      $this->pkColName = $key;
      $this->loadByPk($val);
    }

  }

  /**
   * @return mixed
   */
  public function getCountry(){
    if(isset($this->Country)){
      return $this->Country;
    }else
      $this->setCountry();
    return $this->Country;
  }

  /**
   * @param null $id
   * @return mixed
   */
  public function setCountry($id = null){
    if($id == null) $id = $this->getCountryId();
    $this->Country = new Socnet_Location_Country($id);
    return $this->Country;
  }

  /**
   * @return mixed
   */
  public function getCity(){
    if(isset($this->City)){
      return $this->City;
    }else
      $this->setCity();
    return $this->City;
  }

  /**
   * @param null $id
   * @return mixed
   */
  public function setCity($id = null){
    if($id == null) $id = $this->getCityId();
    $this->City = new Socnet_Location_City($id);
    return $this->City;
  }


  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param $id
   * @return Socnet_Partner
   */
  public function setId($id = null) {
    if($id == 0) return $this;
    $this->id = $id;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param null $name
   * @return Socnet_Partner_Item
   */
  public function setName($name = null) {
    $this->name = $name;
    return $this;
  }

  /**
   * @return mixed
   */
  public
  function getCountryId() {
    return $this->countryId;
  }

  /**
   * @param $countryId
   * @return Socnet_Partner
   */
  public function setCountryId($countryId = null) {
    $this->countryId = $countryId;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getCityId() {
    return $this->cityId;
  }

  /**
   * @param $cityId
   * @return Socnet_Partner
   */
  public function setCityId($cityId = null) {
    $this->cityId = $cityId;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getLongitude() {
    return $this->longitude;
  }

  /**
   * @param $longitude
   * @return Socnet_Partner
   */
  public function setLongitude($longitude = null) {
    $this->longitude = $longitude;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getLatitude() {
    return $this->latitude;
  }

  /**
   * @param $latitude
   * @return Socnet_Partner
   */
  public function setLatitude($latitude = null) {
    $this->latitude = $latitude;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getSiteUrl() {
    return $this->siteUrl;
  }

  /**
   * @param $siteUrl
   * @return Socnet_Partner
   */
  public function setSiteUrl($siteUrl = null) {
    $this->siteUrl = $siteUrl;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getPasswordKey() {
    return $this->passwordKey;
  }

  /**
   * @param $passwordKey
   * @return Socnet_Partner
   */
  public function setPasswordKey($passwordKey = null) {
    $this->passwordKey = $passwordKey;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @param $description
   * @return Socnet_Partner
   */
  public function setDescription($description = null) {
    $this->description = $description;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getUnique() {
    return $this->unique;
  }

  /**
   * @param $unique
   * @return Socnet_Partner
   */
  public function setUnique($unique = null) {
    $this->unique = $unique;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * @param $price
   * @return Socnet_Partner
   */
  public function setPrice($price = null) {
    $this->price = $price;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getPenalty() {
    return $this->penalty;
  }

  /**
   * @param $penalty
   * @return Socnet_Partner
   */
  public function setPenalty($penalty = null) {
    $this->penalty = $penalty;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getInformation() {
    return $this->information;
  }

  /**
   * @param $information
   * @return Socnet_Partner
   */
  public function setInformation($information = null) {
    $this->information = $information;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getMinDay() {
    return $this->minDay;
  }

  /**
   * @param $minDay
   * @return Socnet_Partner
   */
  public function setMinDay($minDay = null) {
    $this->minDay = $minDay;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getShortNumber() {
    return $this->shortNumber;
  }

  /**
   * @param $shortNumber
   * @return Socnet_Partner
   */
  public function setShortNumber($shortNumber = null) {
    $this->shortNumber = $shortNumber;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getCustomId() {
    return $this->customId;
  }

  /**
   * @param $customId
   * @return Socnet_Partner
   */
  public function setCustomId($customId = null) {
    $this->customId = $customId;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getUpdateTime() {
    if(!$this->updateTime)
      $this->setUpdateTime();
    return $this->updateTime;
  }

  /**
   * @param $updateTime
   * @return Socnet_Partner
   */
  public function setUpdateTime($updateTime = null) {
    if ($updateTime == null)
      $updateTime = date('Y-m-d H:i:s');
    $this->updateTime = $updateTime;
    return $this;
  }


  /**
   * @param null $id
   * @return mixed
   */
  public function delete($id = null) {
    if ($id)
      $this->setId($id);

    if ($this->id !== null) {
      $this->status = 'deleted';
      //return parent::save();
      return $this->_db->delete('partner__catalog', $this->_db->quoteInto('id =? ', $this->id));
    }
  }

}