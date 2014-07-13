<?
    if (!$this->_page->_user->isAuthenticated()){
        $this->_redirect('http://'.BASE_HTTP_HOST.'/');
    }
        
    $url = implode("/",array_slice(Socnet::$urlParams,0,5));
    echo "url = $url";    
    $sql  = "SELECT count(*) FROM photos WHERE photos_is_ok = 0 ";
    $num  = $this->_db->fetchOne($sql);

	// get info for paging!    
    if(isset(Socnet::$urlParams[5]))
		    $page = intval(Socnet::$urlParams[5]);
    if(!empty($page))
      $offset = intval($page)*$this->pageSize;
    
    else
    {
       $offset=0;
       $page  =intval($num/$this->pageSize); 
    }
    $this->oUrl->setUrl("http://".BASE_HTTP_HOST."$url/");
    $this->oPaginator->setNumRows($num);
    $info = $this->oPaginator->getPagingInfo($page);
    $this->_page->Template->assign('pgr',$info);
    
    dump($info);
    
    $count = 15;
    $sql = $this->_db->select()
                     ->from('photos')                     
                     ->where('photos_is_ok = ? ',0)
                     ->order('photos_registration_date DESC')
                     ->limit($count,$offset=0);
	$list=$this->_db->fetchAll($sql);
	
	$i=0;
	foreach($list as $key=>$value){
	 //$list[$i]['photos_path']="http://".BASE_HTTP_HOST."/albums/viewAlbum/".$photos[$i]['photos_user_id'].'/'.$photos[$i]['photos_album_id']."/";
	  
     $list[$i]['photos_path'] = "http://".BASE_HTTP_HOST."/upload/user_photos/".
     $list[$i]['photos_user_id'].'/'.$list[$i]['photos_album_id'].'/'.md5($list[$i]['id']).'_small.jpg';
	 $i++;
	}
	//dump($list);
    $this->_page->Template->assign('list',$list);
    $this->_page->Template->assign(array('bodyContent'   => 'admin/photos.list.tpl'));
?>