<?php
/*
 * Created on 05.06.2008
 *
    // delete photo from type::
     * 	board
     * 	news
     * 	ugon
     check:
     	isOwner
     	isLoggedIn
   @input: photo_id, type=[1-5] -> table number
   or smth like that.
 */
 $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
	   
 if(empty($user_id)){
   	$objResponse->addAlert("Вам нужно войти, чтобы выполнить это действие.");	
	return $objResponse;
 }
 	
 $objResponse = new xajaxResponse();

// $module=$Socnet::
$table_id = intval($table_id);
$table_name = Socnet_Photo_Config::getPhotoTableById($table_id);    
// get table name

if(empty($table_name)){
   	$objResponse->addAlert("Удаление фото.Ошибка в запросе!");
   	return $objResponse;
} 

// check owner!
if(!Socnet_Photo_Config::isOwner($table_name,$item_id)){
	$objResponse->addAlert("Хулиганите? Нельзя удалять чужое фото!");
   	return $objResponse;
}
//Socnet_Photo_Config::setTypeName($table_name);
Socnet_Photo_Config::setTypeId($table_id);
Socnet_Photo_Config::removePhoto($item_id,$photo_id);
$objResponse->addScript("deleteImage($photo_id);");
//$objResponse->addAlert('Фото удалено');
return $objResponse;
?>
