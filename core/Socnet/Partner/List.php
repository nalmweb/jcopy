<?
/*
 * Created on 09.02.2012
 * Slauta R.
 */

class Socnet_Partner_List extends Socnet_Data_Entity {
  /**
   * @var
   */
  private  $id;

  /**
   * @var
   */
  private  $returnAsAssoc;


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
    $this->id = $id;
    return $this;
  }

  /**
   * @param $assoc
   */
  public function returnAsAssoc($assoc){
    $this->returnAsAssoc = $assoc;
  }

  /**
   * @return bool
   */
  public function isAsAssoc(){
    return $this->returnAsAssoc ? true : false;
  }

  /**
   * @param null $page
   * @return array
   */
  public function getList($page = null)
  {
    $query = $this->_db->select();

    $query->from('partner__catalog', '*');

    if ( null !== $this->getId() ) {
      $query->where('id = ?', $this->getId() );
    }

    if($page)
      $query->limitPage($page);

    $items = array();
    $items = $this->_db->fetchAll($query);
    foreach($items as $key => $value){
      if($this->isAsAssoc())
        $items[$key] = $value;
      else
        $items[$key] = new Socnet_Partner_Item('id', $value['id']);
    }
    return $items;
  }

  public static function isIdPartnerExists($id){
    $db = Zend::registry("DB");
    $select = $db->select();
    $select->from('partner__catalog','count(id) as count')
      ->where('id = ?', $id);
    $res = $db->fetchOne($select);
    return (boolean) $res;
  }

  public static function isPartnerExists($array){
    $db = Zend::registry("DB");
    $select = $db->select();
    $select->from('partner__catalog','count(id) as count');

    foreach($array as $key => $value)
      $select->orWhere($key .' = ?', $value);

    $res = $db->fetchOne($select);
    return (boolean) $res;
  }

  /**
   * @return string
   */
  public function getCount(){
    $query = $this->_db->select();
    $query->from('partner__catalog', 'count(id)');
    return $this->_db->fetchOne($query);
  }
}