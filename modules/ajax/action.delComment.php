<?php
/*
   - сессия
   - владелиц ли?  
   - update
*/

 $objResponse = new xajaxResponse('utf-8');
 // $objResponse -> addAlert(' table = '.$m_table);
 //return $objResponse;
 $user_id = isset ($_SESSION['user_id'])?$_SESSION['user_id']:0;
 
 if(empty($user_id))
 {
    $objResponse->addAlert("Вам нужно зарегестрироваться либо войти, чтобы удалить коментарий." );	
    return $objResponse;
 }
 
 $table_name = 'comment__'.$m_table;
 
 // check owner
 $sql = " SELECT cid from $table_name WHERE user_id=$user_id and cid = $cid";
 $one = $this->_db->fetchOne($sql);
 
 if(empty($one)){
 	$objResponse->addAlert("Вы не можете удалить данный коментарий." );	
    return $objResponse;
 } 
 
 // иначе он хозяин
 // title=-1 - to know that the comment was deleted.
 
 // if has children - set 'deleted'
 $oComments = new Socnet_Comments($m_table);
 	
 // update 	 
 if($oComments->hasChildren($cid))
 {
	$this->_db->query("update $table_name set title='-1',comment='Комментарий удален',rating=0," .
 					  "user_id=0,user_nickname='' where cid=$cid");
 					  
 	
 	$objResponse->addScript(" var elem=document.getElementById('comment_id_'+$cid);");
	$objResponse->addScript(" elem.innerHTML='Удаленный комментарий' "); 
 }
 else
 {
 	// delete
 	$this->_db->query("delete from $table_name where cid = $cid" );
 	$objResponse->addScript("var elem=document.getElementById('comment_id_'+$cid);");
	$objResponse->addScript("elem.parentNode.removeChild(elem); " );
 } 
 
 $this->_db->query("update $m_table set num_comments = num_comments -1 where id=$parent_id ");
 // If no children - delete
 // $this->_db->query("update $table_name set title='-1',comment='Комментарий удален',rating=0," .
 //		"user_id=0,user_nickname='' where cid=$cid");
// $objResponse->addScript(" elem.
// $('c_content_' + id).innerHTML = 'удаленный коментарий';
//    var node = $('comment_id_' + id);
//		node.parentNode.removeChild(node); 
// }
// else if (type=='update')
//		$('c_content_' + id).innerHTML = 'удаленный коментарий';
// $objResponse->addAssign('comment_id_'.$cid,'innerHTML',"Комментарий удален"); 
?>
