<?php
/*
 * Created on 05.12.2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Socnet_Board extends Socnet_Data_Entity
{
public $id; 
public $user_id; 
public $mark_id; 
//--> only for outfit
public $type_id;
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
 	
public function __construct($table)
{

parent::__construct($table);
  
$this->addField('id'); 
$this->addField('user_id'); 
$this->addField('mark_id');
$this->addField('title'); 
$this->addField('content'); 
$this->addField('custom_name'); 
$this->addField('price_rur'); 
$this->addField('price_brb'); 
$this->addField('price_ua'); 
$this->addField('price_usd'); 
$this->addField('price_eur');
$this->addField('city_id'); 
$this->addField('country_id');
$this->addField('is_new'); 
$this->addField('is_torg'); 
$this->addField('is_selected'); 
$this->addField('is_top'); 
$this->addField('is_active'); 
$this->addField('has_image'); 
$this->addField('h_order'); 
$this->addField('reg_date'); 
$this->addField('end_date'); 
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
} 
//outfit
else if($table=="board__outfit")
	$this->addField('type_id');

 }
 /**
  * 
  */
 public function save()
 {
	$res = parent::save();
	if($res)
		return $this->_db->lastInsertId();
	return 0;
 }
 //
 public function deleteItem($id)
 {
   $this->_db->delete($this->tableName,"id=$id");
 }
} 
?>
