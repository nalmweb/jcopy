<?php
/*
   Created on 10.06.2008
   
   class that contains constants for photos, and actions.
   
 */ 
 class Socnet_Config_Item
 {
  
  private static $PHOTO_TYPES = array(
  63456=>'news',
  20920=>'photos',
  34533=>'meetings__photos',
  23424=>'board__bikes',
  54535=>'ugon__bikes',
  23092=>'board__outfit',
  23492=>'board__details',
  23496=>'mail__photos',
  
  'news'=>63456,
  'photos'=>20920,
  'meetings__photos'=>34533,
  'board__bikes'=>23424,
  'ugon__bikes'=>54535,
  'board__outfit'=>23092,
  'board__details'=>23492,
  'mail__photos'=>23496
 );
 
/**
 *  ID => array(table=>,action=> ) 
 *      
 *  actions for photos in user's area
 * 
 */
 private static $ACTIONS = array (
  'news'=>'/users/editNews/',
  'photos'=>20920,
  'meetings__photos'=>34533,
  'board__bikes'=>23424,
  'ugon__bikes'=>54535,
  'board__outfit'=>23092,
  'board__details'=>23492,
  'mail__photos'=>23496
 );
 	
 public static function getPhotoTableById($id){
	return isset(self::$PHOTO_TYPES[$id])?self::$PHOTO_TYPES[$id]:null;
 }

 public static function getIdByPhotoTable($table){
	return isset(self::$PHOTO_TYPES[$table])?self::$PHOTO_TYPES[$table]:null;
 }
} 
?>