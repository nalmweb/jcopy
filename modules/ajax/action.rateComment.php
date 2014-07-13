<?php
/*
 
1 news
2 photos
3 meetings
4 meetings_photos
5 user
 
 	check session
 
    check user not rated.
    
    update rate info
    
    update rate.

    type = // set in html?
    
    module/action!
    
*/

 /*dump($_SERVER);
   if($_SERVER['REQUEST_METHOD'] == 'POST')
 {*/
 // $type,$comment_id,$sign
 $objResponse = new xajaxResponse();
 $user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
 
 if( empty ($user_id)){
 	$objResponse->addAlert("Вам надо залогиниться, чтобы голосовать за комментарии.");
 	return $objResponse;
 }
 
 // check not rated. - if rated - m.b disabled. - in case of hack..
    $oRate = new Socnet_Rating_Item();
    
  if(!$oRate->isRated($type,$cid,$user_id))
  {
	$oRate->setUserId($user_id);
	$oRate->setType($type);
	$oRate->setCommentId($cid);
	$oRate->save();
	
	// update info
	$sign = ($sign > 0 )?1:-1;
	$rating = $oRate->updateRating($sign);
	$objResponse->addAssign('rate_'.$cid, 'innerHTML', $rating);
		
  }
  else
  {
  	$objResponse->addAlert("А за это, вы уже голосовали!");
 	return $objResponse;
  }
 /*}
 else
   header("Location: /");*/
?>
