<?php
/**
    'bikes' :	$cat_id=1; 
    'details': $cat_id=2; 
	'outfit' : $cat_id=3;
 */
class Socnet_Board_Item extends Socnet_Data_Entity
{
public  $imagePath;
public  $imageList;
private $cat_id;

public $id;
public $user_id; 
public $mark_id; 
public $model_id;
public $type_id;
//--> only for outfit
//public $type_id;
public $kind_id;
public $size;
//<-- 
//-->for details and outfit
public $name;
//<--
//--> only for details
public $mark_details_id;
//<--
public $title; 
public $content; 
public $custom_name; 
public $price_rur; 
public $price_brb; 
public $price_ua; 
public $price_usd; 
public $price_eur;
public $city_id; 
public $country_id;
//-->only for bikes
public $kpp; 
public $volume; 
public $probeg; 
public $year; 
public $power;
//<--
public $condition;
public $is_new;
public $is_torg;
public $is_selected;
public $is_top;
public $is_active; 
public $has_image; 
public $h_order; 
public $reg_date; 
public $end_date; 
public $skype; 
public $phone; 
public $icq;

public $City;
public $Country;
public $Photos;

private $m_table;
private $numPhotos;    
    
public function __construct ($cat_id,$id = null)
{

$this->pkColName = 'id';

$table='';
if($cat_id==1)$table="board__bikes";
else if($cat_id==2)$table="board__details";
else if($cat_id==3)$table="board__outfit";
$this->cat_id = $cat_id;

parent::__construct($table);

$this->m_table = $table;

$this->addField('id'); 
$this->addField('user_id','userId'); 
$this->addField('mark_id','markId');
$this->addField('type_id','typeId');
$this->addField('title'); 
$this->addField('content'); 
$this->addField('custom_name','customName'); 
$this->addField('price_rur','price'); 
$this->addField('price_brb'); 
$this->addField('price_ua'); 
$this->addField('price_usd'); 
$this->addField('price_eur');
$this->addField('city_id','cityId'); 
$this->addField('country_id','countryId');
$this->addField('condition');
$this->addField('is_new','isNew'); 
$this->addField('is_torg','isTorg'); 
$this->addField('is_selected','isSelected'); 
$this->addField('is_top','isTop'); 
$this->addField('is_active','isActive'); 
$this->addField('has_image','hasImage'); 
$this->addField('h_order','order'); 
$this->addField('reg_date','regDate'); 
$this->addField('end_date','endDate');
$this->addField('skype'); 
$this->addField('phone'); 
$this->addField('icq');
//bikes
if($table=="board__bikes"){
$this->addField('kpp'); 
$this->addField('volume'); 
$this->addField('probeg'); 
$this->addField('year'); 
$this->addField('power');
$this->addField('model_id','modelId');
}
//outfit
else if($table=="board__outfit")
{
	$this->addField('kind_id','kindId');
	$this->addField('size');
}
else if($table=="board__details")
{
	$this->addField('mark_details_id','markDetailsId');
	$this->addField('model_id','modelId');
}
 if( null !== $id )
 {
   $this->loadByPk($id);
   $this->getImageList();
   // $this->getImageList();
 }
}
    /**
     * @return unknown
     */
    public function getId (){
       return $this->id;
    }
    public function setId  ($val){
    	$this->id = $val;	
    }
    // 
    public function getCatId(){
       return $this->cat_id;
    }
    public function setCatId  ($val){
    	$this->cat_id = $val;	
    }    
    
    public function setUserId($val){
    	$this->user_id=$val;
    }
    
    public function getUserId(){
    	return $this->user_id;
    }

	/**
	 *   @return: string. A text string = type of bike;
	 */ 
    public function getBikeType()
    {
      $bikeType = new Socnet_Catalog_Property_Item(1);
   	  $bikeType->setId(1);
   	  $data = $bikeType->getListData();
      
      foreach ($data as $key => $value){
      	  if($key ==$this->type_id){
      	  	return $value;
      	  }
      }
      return null;
    }
    
    /**
     *   @param int $v - an id of details producer.
     */
    public function setMarkDetailsId($v){
    	$this->mark_details_id = $v;
    }
    
    public function getMarkDetailsId(){
    	return $this->mark_details_id;	
    }
    
    /**
     *  @return: The name of detail's producer;
     */
    public function getDetailsMark()
    {
      $sql=$this->_db->select()->from("catalog__trademark")->where("id=?",$this->mark_details_id)
      													   ->where("id_type_auto=?",DETAILS_TRADEMARK);
      $rs=$this->_db->fetchAll($sql);
      // dump($rs);
      if(!empty($rs))
      {
      	$rs=$rs[0];
      	return $rs['name'];  
      } 
      else 
      	 return '';
    }
    
    /**
     *  @return: the type of details now.  
     */
    public function getDetailsType()
    {
      $sql=$this->_db->select()->from("board__details_names")->where("id=?",$this->type_id);
      // echo "sql=".$sql->__toString();
      $rs =$this->_db->fetchAll($sql);
      // dump($rs);
      if(!empty($rs))
      { 
      	$rs = $rs[0];
      	return $rs['name'];  
      } 
      else return null;
    }    
    //
    public function getMark()
    {
      if(!empty($this->custom_name))
      	  return "Другой";// $this->custom_name;
      
      // only for details
      if($this->mark_id < 0)
      {
      	 return "Для всех";
      }
      
      $sql=$this->_db->select()->from("catalog__trademark")->where("id=?",$this->mark_id);
      $rs=$this->_db->fetchAll($sql);
            
      if(!empty($rs)){
      		$rs = $rs[0];
      		
      	return $rs['name'];
      }
      return false;
      
    }
    
    //     
    public function getMarkId(){ return $this->mark_id; }
    
    public function setMarkId  ($val){
    	$this->mark_id = $val;	
    }
    
    /**
	    
	*/
    public function getOutfitType()
    {
	   $sql=$this->_db->select()->from("catalog__outfit","title")->where("cid=?",$this->type_id);
	   $res=$this->_db->fetchCol($sql);
	   
	   if(!empty($res)) return $res[0];
	   else return null;
    }
    /**
	
	*/
    public function getOutfitKind()
    {
       $sql=$this->_db->select()->from("catalog__outfit","title")->where("cid=?",$this->kind_id);
	   $res=$this->_db->fetchCol($sql);
	   
	   if(!empty($res)) 
	   		return $res[0];
	   else 
	   		return null;	
    }
    
    public function getKindId () { return $this->kind_id; }
    
    public function setKindId  ($val){
    	$this->kind_id = $val;	
    }
    
    // 
    public function getModel()
    {
	  // model_id is an id in catalog__model_god not an id_model
	  //$model_year = new Socnet_Catalog_Model_Year_Item($this->model_id);
	  $model = new Socnet_Catalog_Model_Item($this->model_id);
	  $name = $model->getName();
	  
	  if(!empty($name)) return $name;	  
      return false;
    }
    
    public function getModelIdYear(){    	
    	
    	$sql = $this->_db->select()->from('catalog__model_god')
    		->where('id_model = ?',$this->model_id)
    		->where('god = ? ', $this->year);
    	$idModelYear = $this->_db->fetchOne($sql);	
    	
    	return $idModelYear;
    }
    
    public function getModelId(){
    	return $this->model_id;
    }
    public function setModelId  ($val){
    	$this->model_id=$val;	
    }
    
    //
    function getSize() 		 { return $this->size;}
    
    function getCustomName() { return $this->custom_name;}
    
    public function setCustomName  ($val){
    	$this->custom_name=$val;	
    }
   
    /**
     *  In which currency to return?
     *  default:rur, so far.
     */
    public function getPrice(){ return $this->price_rur; }
    public function setPrice  ($val){
    	$this->price_rur = $val;	
    }
    
    public function getYear(){ return $this->year; }
    public function setYear  ($val){
    	$this->year = $val;	
    }
    
    public function getProbeg()
    {
    	return $this->probeg;
    }
    
    public function setProbeg  ($val){
    	$this->probeg = $val;	
    }
    
    public function getVolume()
    {
    	return $this->volume;
    }
    public function setVolume  ($val){
    	$this->volume=$val;	
    }
    
    // 
    public function getCondition()
    {
    	return $this->condition;
    }
    public function setCondition  ($val){
    	$this->condition = $val;	
    }
    
    // @return: horse power:
    public function getPower()
    {
    	return $this->power;
    }
    
    public function setPower($val){
    	$this->power = $val;	
    }
    // @return: Сity object 
 	public function getCity()
    {
    	if ( null === $this->City ){
    		$this->setCity();
    	}
    	return $this->City;   	
    }
    
    public function getCityId(){
    	return $this->city_id;
    }
    public function setCityId  ($val){
    	$this->city_id = $val;	
    }
    
    public function getCountry(){
    	if ( null === $this->Country) {
    		$this->setCountry();
    	}
    	return $this->Country;
    }
    
    public function getCountryId(){
    	return $this->country_id;
    }
    public function setCountryId ($val){
    	$this->country_id = $val;	
    }
    public function getTitle(){
    	return $this->title;
    }
    
    public function setTitle  ($val){
    	$this->title = $val;	
    }
    // 
    public function setCity()
    {
    	$this->City = new Socnet_Location_City($this->city_id);
    	return $this;
    }
    public function getKpp()
    {
    	return $this->kpp;
    }
    public function setKpp  ($val){
    	$this->kpp = $val;	
    }
    
    public function getTorg()
    {
    	return $this->is_torg;
    }   
          
    public function getContent()
    {
    	return $this->content;
    }
    public function setContent($val){
    	$this->content=$val;
    }
    // 
    public function getSkype()
    {
      return $this->skype;
    }
    public function setSkype($val){
    	if(!$val)
    		$val="";
    	$this->skype=$val;
    }
    
    public function getICQ(){
      return $this->icq;	
    }
    public function setICQ($val){
    	
    	if(!$val)
    		$val="";
    	$this->icq=$val;
    }
    
    public function getPhone(){
      return $this->phone;	
    }
    
    public function setPhone($val){
        if(!$val)
    		$val="";
    	$this->phone=$val;
    }
    /**
     *   
     *   @return string a type for a bike
     */
    public function getType(){
    	$select = $this->_db->select();
    	$select->from("catalog__model","name")->where("id=?",$this->type_id)->limit(1);
    	$rs=$this->_db->fetchCol($select);
    	
    	if(!empty($rs))
    		return $rs[0];
		else
			return "";
    }
    
    public function getTypeId(){ return $this->type_id; }
    public function setTypeId($val){ $this->type_id=$val; }
    
    public function getIsNew () { return $this->is_new; }
    public function setIsNew ($val) { $this->is_new=$val; }
    
    public function getIsSelected () { return $this->is_selected; }
    public function setIsSelected ($val) { $this->is_selected=$val; }
    
    public function getIsTop () { return $this->is_top; }
    public function setIsTop ($val) { $this->is_top=$val; }
    
    public function getIsTorg () { return $this->is_torg; }
    public function setIsTorg ($val) { $this->is_torg=$val; }
    
    public function getIsActive () { return $this->is_active; }
    public function setIsActive ($val) { $this->is_active=$val; }
    
    //-->
    // used in [outfit]: get kind of helmet for instance:
    // using type_id
    public function getKind()
    {
		$select = $this->_db->select();
    	$select->from("catalog__data_list_property","name")->where("id_property=?",$this->type_id);
    	$rs=$this->_db->fetchCol($select);
    	if(!empty($rs))return $rs[0];
		else return "";
    }
    
    /**
     *   @return:  /upload/board/12/sdfk234ljsf2sf
     *   need to add _small _big or medium
     */
    public function getImageList()
    {
	   if(!empty($this->Photos))
	   		$this->Photos->getImageList();
	    else{
	    	$this->Photos = new Socnet_Board_Photo();
	    	$this->Photos->setItemId($this->id);
	    	$this->Photos->setCatId($this->cat_id);
	    }
	    return $this->Photos->getImageList();
    }
    
    // @TODO: delete
    public function getImages(){    	    	
    		return $this->getImageList();
    }
    
    public function hasImages()
    {
       $num =0;
       if(!empty($this->Photos))
       	  $num = $this->Photos->getNumPhotos();
       else{
       		$this->Photos = new Socnet_Board_Photo($this->id);
       		$this->Photos->setCatId($this->cat_id);
	    	$num = $this->Photos->getNumPhotos();
       }
       return $num;
 }
    
 public function save()
 {
	$res = parent::save();
	
	if(empty($this->id))
		return $this->_db->lastInsertId();
	else
		return $this->id;
 }
 /** 
  * 
  */
 public function bExists($item_id){
 	
 	$sql = $this->_db->select()->from($this->m_table)->where("id=?",$item_id);
 	$id = $this->_db->fetchCol($sql);
 	if(!empty($id))
 		return true;
    return false;		
  }  
 
  /**
   *  Checks that user owns that item;
   */
  public function isOwner($id=''){
	
	if(empty($id)) $id = $this->id;
	  	
  	$sql=$this->_db->select()->from($this->m_table)->where("id=?",$id)->where("user_id =?",$_SESSION['user_id']);
  	$rs =$this->_db->fetchCol($sql);
  	
  	if(!empty($rs)){
  		return true;
  	}
  	return false;
  }
  // 
  public function deleteItem()
  {
	  // Socnet_Board_Photo
	  // how to delete photos?
	  $oPhoto = new Socnet_Board_Photo();
	  //echo "id=".$this->id;
	  $photosList = $oPhoto->getList($this->id,$this->cat_id);
	  // dump($photosList);
	  if($this->cat_id ==1)
	  	Socnet_Photo_Config::setTypeId(Socnet_Photo_Config::$BOARD_BIKES);
	  else if ($this->cat_id ==2)
	    Socnet_Photo_Config::setTypeId(Socnet_Photo_Config::$BOARD_DETAILS);	
	  else if ($this->cat_id ==3)
	    Socnet_Photo_Config::setTypeId(Socnet_Photo_Config::$BOARD_OUTFIT);	    
	  
	  foreach($photosList as $photo_id=>$item){
			// echo "photo_id=$photo_id";
		   	Socnet_Photo_Config::removePhoto($this->id,$photo_id);
	  }
	  Socnet_Photo_Config::removeDir($this->id);
	  // exit;
	  // Socnet_Photo_Config::removePhoto($);
	  parent::delete();
  }
  //
  public function getNumPhotos(){
   	  //return $this->numPhotos;
   	  return $this->Photos->getNumPhotos();
  }
  public function getRegDate(){
  	return $this->reg_date;
  }
  public function setRegDate($date){
   	   $this->reg_date = $date;
  }
  public function getEndDate(){
    	return $this->end_date;
  }
  public function setEndDate($date){
   		$this->end_date = $date;
  }
  /**
   *   Get a number of ads in a board section per user 
   *   @this
   */
  public function getNumAds(){
     
     $sql= " select count(*) from $this->m_table where is_active = 1 AND " .
     		"user_id = ".$_SESSION['user_id'];
     		
     $res = $this->_db->fetchCol($sql); 
     
     if($res)
     {
        return $res[0];  	
     }
     return 0;
  }
  
  /**
   *  @return boolean true  if user can add an item to board
   * 				  false if can't
   */
  public function canAdd()
  {
  	 if($this->getNumAds()>=BOARD_MAX_ADS)
  	 {
  	 	return false;
  	 }
  	 else
  	 {
  	 	return true;
  	 }
  }
}
?>
