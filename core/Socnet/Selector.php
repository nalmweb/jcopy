<?php
/*
 * Created on 17.10.2007
 *
 * To change the template for this generated file go to
 *  class for all kinds of selects;
 */ 
  class Socnet_Selector
  {
 	  private $_db; 
 	  private $news_count=5;
 	  private $random_news=5;
 	   
      function __construct($db){
      	$this->_db = $db;
      }
      
      /**
       *  select some news-get random from them.
       */
      function getRandomNews(){
      	
      	$sql=$this->_db->select()
      				->from("news",array('1' => "id",'2' => "news_section_id",'3'=>"news_title",'4' =>"num_comments",'5' => "news_registration_date"))
      				->joinLeft(array( 't' => "news__categories"),"news_section_id = t.cat_id")
      				->where("news_is_ok = ?",1)->order("news_registration_date DESC")->limit(100,0);

      	$rs=$this->_db->fetchAll($sql);
      	//dump($rs);
      	// зачем проверять случай, когда новостей мало? для начала только если
      	$size=count($rs)-1;
      	
      	//echo "s=$size<br>";
      	
      	if($size < $this->random_news)
      		$this->random_news = $size-1;
      	
      	$news_numbers = array();
      	$temp = mt_rand(0,$size);
      	
      	// echo "rand=".$this->random_news."<br>";
      	
      	for($i=0; $i<$this->random_news; $i++)
      	{
      	   $temp = mt_rand(0,$size);
      	   do
      	   {
      	     if(!array_key_exists($temp,$news_numbers)){
      	   	   $news_numbers["$temp"] = $temp;
      	   	   break;
      	     }
      	     else
      	     {
      	       $temp = mt_rand(0,$size);
      	       continue;
      	     }
      	   }while(true);
      	}
      	      	
      	$news_numbers = array_values($news_numbers);
      	$res = array();
      	
      	foreach($news_numbers as $item){
      	   $res[] = $rs[$item];
      	}
      	return $res;
      }
      
      function getLastNews()
      {
        /*$sql = $this->_db->select()->from(array('t1' => 'news'))
					  ->where('news_is_ok = 1 ')
					  ->joinLeft( array('t2' => 'news__categories' ), " t1.news_section_id = t2.cat_id" )
					  ->joinLeft( array('t3' => 'user' ), " t1.news_user_id = t3.id",array("id","nikname"))
					  ->order('news_registration_date DESC')
					  ->limit($this->news_count,0);*/
	   $sql = " SELECT t1.*,t2.*,t3.nikname FROM news t1 left join news__categories t2 ON t1.news_section_id = t2.cat_id" .
	   		  "	left join user t3 ON t1.news_user_id = t3.id where news_is_ok=1 ORDER BY news_registration_date DESC LIMIT 0,".$this->news_count;
	   //echo " sql = ".$sql->__toString(); 					  
       $news = $this->_db->fetchAll($sql);
       // dump($news);
       
       if(!empty($news))
       {
         $c=0;
         
	 	 foreach ($news as $news_item)
		 {
		  $path = NEWS_DIR.$news_item['news_section_id']."/".md5($news_item['id'])."_small.jpg";
		  
		  if(file_exists($path))
			$news[$c]['news_photo'] ="http://".BASE_HTTP_HOST."/".NEWS_PHOTOS."/".$news_item['news_section_id']."/".md5($news_item['id'])."_small.jpg";
		  // echo " id = ".$news_item['news_user_id']." <br>";
		  // dump($user->getAvatar()->getSmall());
		  $user = new Socnet_User('id',$news_item['news_user_id']);
		  $news[$c]['userpic']   = $user->getAvatar()->getSmall();
		  $news[$c]['user_name'] = $news_item['nikname'];		   
		  $c++;
		 }
		 //dump($news);
        }
        return $news;
       }

      // must include meetings too. 
      function getLastPhotos()
      {
        $count=9;
        $sql = "SELECT `t1`.*,`t1`.id as photos_id,`t2`.nikname FROM `photos` AS `t1` 
			   LEFT JOIN `user` AS `t2` ON t1.photos_user_id = t2.id 
			   WHERE (photos_public = 1 ) ORDER BY `photos_registration_date` DESC LIMIT $count";
		/*$sql = $this->_db->select()
                     ->from( array( 't1' =>'photos'),array('id as photos_id'))
                     ->where('photos_public = ? ',1)
                  //   ->joinLeft(array( 't2' => 'user' )," t1.photos_user_id = t2.id")
                     ->order('photos_registration_date DESC')
                     ->limit($count,$offset=0);*/
  		//echo "=>".$sql->__toString();
  		//$photos = $this->_db->fetchAll($sql);
  	    $photos = $this->_db->fetchAll($sql);
  	    //dump($photos);
        $i=0;
        
		foreach ($photos as $value)
	    {  
	      /*$photos[$i]['path'] = "http://".BASE_HTTP_HOST."/upload/user_photos/".$photos[$i]['photos_user_id']
	    					  .'/'.$photos[$i]['photos_album_id'].'/'.md5($photos[$i]['photos_id']).'_small.jpg';*/
	    					  
		 $photos[$i]['path'] = "http://".BASE_HTTP_HOST."/upload/user_photos/".$photos[$i]['photos_user_id']
	    					  .'/'.$photos[$i]['photos_album_id'].'/'.md5($photos[$i]['photos_id']).'.jpg';
	    					  
	    					  
	      $photos[$i]['album_path']="http://".BASE_HTTP_HOST."/albums/photo/id/".$photos[$i]['id']."/";
	    
	      $user = new Socnet_User('id',$photos[$i]['photos_user_id']);
		  $photos[$i]['userpic']= $user->getAvatar()->getSmall();
		  $photos[$i]['nikname']= $user->getNikname();
	      $i++;
	    }
        return $photos;
      }
      
      function getAnonPhotos()
      {
        $count = 5;
		$sql = $this->_db->select()
                     ->from( array( 't1' =>'photos'))
                     ->where('photos_public = ? ',1)
              //       ->joinLeft(array( 't2' => 'user' )," t1.photos_user_id = t2.id")
                     ->order('photos_registration_date DESC')
                     ->limit($count,$offset=0); 
      
        $photos = $this->_db->fetchAll($sql);
        $i=0;
	
		foreach ($photos as $value)
		{
	     $photos[$i]['path'] = "http://".BASE_HTTP_HOST."/upload/user_photos/".
	     $photos[$i]['photos_user_id'].'/'.$photos[$i]['photos_album_id'].'/'.md5($photos[$i]['id']).'_medium.jpg';
	     $photos[$i]['album_path']="http://".BASE_HTTP_HOST."/albums/photo/id/".$photos[$i]['id']."/";
	     
	     $user = new Socnet_User('id',$photos[$i]['photos_user_id']);
		 $photos[$i]['userpic']= $user->getAvatar()->getSmall();
		 $photos[$i]['nikname']= $user->getNikname();
	     $i++;
		}
        return $photos;
      }
      
      // 
      function getLastUsers(){
      	$sql= $this->_db->select()->from('user')->where('1=?',1)->order("register_date DESC")->limit(5,0);
      	$users = $this->_db->fetchAll($sql);
  		$i=0;
		foreach($users as $item)
		{	  		    	
	      	$user = new Socnet_User('id',$users[$i]['id']);
			$users[$i]['userpic']= $user->getAvatar()->getSmall();
			$users[$i]['nikname']= $user->getNikname();
			$users[$i]['experience'] = $this->getExp($user->getExperience());
			$users[$i]['age']		=$user->getAge();
			$i++;
		}
		return $users;
      }
      
      function getExp($exp)
      {
      		if($exp < 1 ) 
			  return "менее года";
			else if ($exp ==1)
			  return "1 год"; 
			else if( ($exp >=2 && $exp <=4) )
			  	return "$exp года";
			else if ($exp == 13 || $exp == 14 || $exp==12)
				  return "$exp лет";
			else if( ($exp%10==2) || ($exp%10==3) || ($exp%10==4) )
				return "$exp года";
			else 	
				return "$exp лет";
      }
  }
?>
