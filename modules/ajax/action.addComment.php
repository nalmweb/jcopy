<?php
/*
 * Created on 21.12.2007 
    - get data.
  	- update 
  	- save
  	- какие переменные берутся извне?
*/
$lastID=0;
$objResponse = new xajaxResponse('utf-8');
//$objResponse -> addAlert(' table = '.$m_table);
//return $objResponse;
 if(empty($_SESSION['user_id']))
 {
    $objResponse->addAlert("Вам нужно зарегестрироваться либо войти, чтобы добавить коментарий." );	
    return $objResponse;
 }
  
 $res = Socnet_Censure::censure($comment);
  
  if($res)
  {
    $objResponse -> addAlert("У нас не матеряться! ".$res);
    return $objResponse;
  }
    
  if(empty($comment))
  {
     $objResponse->addAlert("Введите комментарий!");	
     return $objResponse;
  }
  $oDbtree=Zend_Registry::get("DBTREE");
  //$objResponse->addAlert("dbtree mtable=$m_table");
  // return $objResponse;
  $comment = str_replace("'","&#039;", $comment);
  $comment = Socnet_Comments::clean_comment($comment);
  $comment = nl2br($comment);
  
  $data['user_id']       = $_SESSION['user_id']; // set user id!
  $data['user_nickname'] = $this->_page->_user->nikname;
  $data['comment']       = $comment;
  $data['rating']		 = 0;  
  $data['registration_date']=strftime("%Y-%m-%d %H:%M:%S",time());
    // get comment ID from $mode table
    $root_id=0;
    $sql='';
    //if it is parent ID:: then??? add comments to the parent
	//get comment_id from table.
    if($type=='p')
    {      	
	   $sql=$this->_db->select()->from($m_table,"comment_id")->where("id=?", $node_id);
	   //$objResponse->addAlert("sql=".$sql->__toString());
	   //return $objResponse;
       $root_id=$this->_db->fetchOne($sql);
       //$objResponse->addAlert('root_id ='.$root_id);
       // return $objResponse;
    }
    // TODO: check dat root_id exists: someone deleted this artic
    // add comments to comments
    // ADD COMMENT TO NON-PARENT
    else 
    {
     // return $objResponse;
     //$objResponse ->addAlert(" res =   m  table = ".$m_table);	
     //return $objResponse;
  	  $this->table_name = 'comment__'.$m_table;
 	  $root_id = $node_id;
 	  $sql = $this->_db->select()->from($this->table_name,array('cid'))->where("cid = ? ",$root_id);
 	  $res = $this->_db->fetchOne($sql);
	  if(empty($res)) $root_id = 0;
    }
         
	if(!empty($root_id))
	{
        //$objResponse->addAlert('root_id ='.$root_id);
        //return $objResponse;
        /*
	     * For Users -> need to update comment__user_list: who_user_id , put cmoment to whom_user_id
	     */
		 $oDbtree->setTable("comment__".$m_table);
		  
	    if($m_table=='user')
	    {
	   	 $whom_user_id =$node_id;
	   	 $oUComments = new Socnet_UserComments();
	   	 $oUComments->who_user_id  = $_SESSION['user_id'];
	   	 $oUComments->whom_user_id = $node_id;
	   	 $oUComments->save();
	   	 $objResponse->addScript("hideForm('addCommentForm')");
	   	 // also hide add Comment form
	    }
        // $objResponse-> addAlert("root= ".$oDbtree->getTable());
        // return $objResponse;
        // if($m_table!='user')
        $lastID = $oDbtree->insert($root_id,$data);
        /*$objResponse-> addAlert("LastID=".$lastID);
        return $objResponse;*/  
        //-->UPDATE NUM COMMENTS
		if (!empty ($lastID))
		{
		   $sql = "UPDATE $m_table SET num_comments=num_comments+1 WHERE id = '$prod_id' ";
		   $this->_db->query($sql);
		   // $objResponse-> addAlert("root= ".$node_id." sql".$sql);
           // return $objResponse;
           // $mail = Socnet_Mail_Notofication::factory( $m_table );
           //DUMP($mail);
           //exit;
		}
	 }
     //-->::SETUP RESPONSE::<--
 	 $info  =$oDbtree->getNodeInfo($lastID);
	 $level =$info['2'];
	 $status=1;
	 $parentID 		=$node_id;
	 $data['cid']   =$lastID;
	 $data['clevel']=$level*10;
	 //$avatar = new Socnet_User_Avatar($_SESSION['user_id']);
	 $data['user_avatar'] =$this->_page->_user->getAvatar()->getSmall(); 
	 //$avatar->getSmallById($_SESSION['user_id']);
	 $this->_page->Template->assign('item',$data);
	 $html = $this->_page->Template->getContents('comments/single_comment.tpl');
	 
	 $objResponse->addScript("showButton()");
	 $objResponse->addScript("hideForm('id{$parentID}')");
	 $objResponse->addAppend('comment_id_'.$parentID,'innerHTML',$html);
	
	 if($type=='p')
		$objResponse->addScript("hideForm('addCommentForm')");
			
	return $objResponse;
/*
   else
   {
	 $objResponse->addScript("failed(1)".$sql->__toString());
   }*/
  // TODO: SEND ERROR
  // $response->addAssign('error','innerHTML','Ошибка при добавлении в базу данных');
  // $objResponse->addScript("failed(2)");