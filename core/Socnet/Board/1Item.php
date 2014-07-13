<?php
/*
 * Created on 05.12.2008
 *
 */
 /*
   	id  	
	cid 	
	user_id
	title 	
	content
	
	region_id
	city_id
	
	name 	
	phone
	email
	url
	
	is_torg
	is_active
	h_order
	is_selected
	reg_date
	
	update_date? 
	end_date
	
*/ 

class Socnet_Board_Item extends Socnet_Data_Entity 
{

private $id; 
private $cid;
private $user_id; 
private $title; 
private $content;
private $region_id; 
private $city_id; 
private $name; 
private $phone; 
private $email; 
private $url; 
private $is_torg; 
private $is_active;
private $is_selected; 
private $h_order; 
private $reg_date; 
private $end_date;

private $m_table = "board__ads";
 	//  
 	public function __construct ($id = null )
 	{
 		parent::__construct($this->m_table);
 		
		$this->addField('id'); 
		$this->addField('cid');
		$this->addField('user_id','userId'); 
		$this->addField('title'); 
		$this->addField('content');
		$this->addField('region_id','regionId'); 
		$this->addField('city_id','cityId'); 
		$this->addField('name'); 
		$this->addField('phone'); 
		$this->addField('email'); 
		$this->addField('url'); 
		$this->addField('is_torg','torg'); 
		$this->addField('is_active','active');
		$this->addField('is_selected','selected'); 
		$this->addField('h_order','order'); 
		$this->addField('reg_date','date'); 
		$this->addField('end_date','endDate');
 		
 		if(null !== $id)
 		{
 			$this->loadByPk($id);
 		}
 	}

public function getId()		{return $this->id ; } 
public function getCid()	{return $this->cid; }
public function getUseId()  {return $this->user_id; } 
public function getTitle()  {return $this->title; } 
public function getContent(){return $this->content; }
public function getRegionId(){return $this->region_id; } 
public function getCityId()	 {return $this->city_id; } 
public function getName()	 {return $this->name; } 
public function getPhone()	 {return $this->phone; } 
public function getEmail()	 {return $this->email; } 
public function getUrl()	 {return $this->url ; } 
public function getTorg()	 {return $this->is_torg ; } 
public function getActive()  {return $this->is_active ; }
public function getSelected(){return $this->is_selected; } 
public function getOrder()   {return $this->h_order; } 
public function getDate()	 {return $this->reg_date; } 
public function getEndDate() {return $this->end_date; }

public function setId($v)		{return $this->id =$v; } 
public function setCid($v)		{return $this->cid=$v; }
public function setUseId($v) 	{return $this->user_id=$v; } 
public function setTitle($v)  	{return $this->title=$v; } 
public function setContent($v)  {return $this->content=$v; }
public function setRegionId($v) {return $this->region_id=$v; } 
public function setCityId($v)	{return $this->city_id=$v; } 
public function setName($v)	 	{return $this->name=$v; } 
public function setPhone($v)	{return $this->phone=$v; } 
public function setEmail($v)	{return $this->email=$v; } 
public function setUrl($v)	    {return $this->url =$v; } 
public function setTorg($v)	    {return $this->is_torg =$v; } 
public function setActive($v)   {return $this->is_active =$v; }
public function setSelected($v) {return $this->is_selected=$v; } 
public function setOrder($v)    {return $this->h_order=$v; } 
public function setDate($v)	    {return $this->reg_date=$v; } 
public function setEndDate($v)  {return $this->end_date=$v; }

 	
 	//@return last insert id or the current id.
 	public function save ()
 	{
 		parent::save();
 		
 		if(empty($this->id))
			return $this->_db->lastInsertId();
		else
			return $this->id;
 	}
}
?>