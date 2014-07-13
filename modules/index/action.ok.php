<?php

  // $_SESSION['register'] = '123';
  
  $this->_page->Template->assign('invite',true);
  $this->_page->Template->assign('invite_template','invite.success.tpl');
  
  // $this->_page->Template->assign('invite_template','invite.tpl');
  /*if (isset ($_SESSION['register']) )
  {
	echo "sadf";
	$this->_page->Template->assign('invite',true);  
	  
    $this->_page->Template->assign('invite_template','invite.success.tpl');
  }
  else 
    $this->_redirect("/");*/
    
 /*    
    // $params=$_POST[''];
    $user = new Socnet_User();
    $user->setId(null);
    $user->setCityId(1);
    $user->setMetroId(1);
    $user->setBirthday('1985-05-05');
    $user->setGender($this->params['gender']);
    $user->setLogin($email);
    $user->setPass(md5($pass));
    $user->setAdmin(false);
    $user->setStatus('pending');
    $user->setRegisterDate(date('Y-m-d H:i:s', time()));
	$user->setExperience('2008-01-01');
    $user->setNikname($nick);
    $user->setBirthdayPrivate(1);
    $user->setview_as           =1;
    $user->user_num_comments    =0;

    unset($_SESSION['reg_user']);
    
    //get coords
    // $city = new Socnet_Location_City($this->params["cityId"]);
    $user->latitude          = 55.73948;
    $user->longitude         = 37.62817;
    $user->save();

    if ( isset( $this->params['newBike'] ) && '' !==  trim( $this->params['newBike'] ) ){
        $data['userId'] = $user->getId();
        $data['request'] = $this->params['newBike'];
        $request = new Socnet_Admin_Collection();
        $request->addRequestToNewBike($data);
    } else {
        $user->setBikeId($this->params['years']);    
        $user->save();
    }
    unset($_SESSION['verify_code']);
    $mail_confirm_url = $user->registerCode;
    //  Send message
    //$_SESSION['reg_user'] = array('login'  => $this->params['login']);
    $this->_redirect('/index/success/');
}
*/
?>
