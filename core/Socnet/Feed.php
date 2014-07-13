<?   /**
     *  common class for news and gallery
     *  TODO: count - get from config;
     */
    class Socnet_Feed 
    {
          private $oRssGen;
          private $title='Socnet rss for ';
          private $link;
          private $descr='';
          private $_db;
          private $num_items;
        
          function __construct($db, $num_items)
          {
            $this->link = 'http://'.BASE_HTTP_HOST;
            $this->_db  = $db;
            $this->num_items=$num_items;
          }
          
          /* Без абв..., без локали */
		  function gw2_smart_wordwrap($str, $limit = 256)
		  {
	        /* волшебный символ */
	        $splitter = "\x0";
	        /* определяем длину строки */
	        $int_len = strlen($str);
	        /* этим стоит заняться, если длина строки больше, чем надо */
	        if ($int_len > $limit)
	        {
	                /* разрезаем обычным wordwrap'ом */
	                $str = wordwrap($str, $limit, $splitter);
	                /* ищем, где wordwrap оборвал строку первый раз */
	                $int_s = strpos($str, $splitter);
	                /* если символа обрыва вообще нет, значит строка
	                оказалась не такой длинной и оборвалась правильно.
	                */
	                if ($int_s === false) { $int_s = $limit; }
	                return substr($str, 0, $int_s). ' ... ';
	        }
	        return $str;
		  }
          
          /**
           *   @param unknown_type $type:: news|gallery
           *   What about feeds for comments? 
           */
          function createFeed ($type)
          {
              //$xml = '';
              switch ($type){
                  case 'news':   $this->createNewsRss();break;
                  case 'photos':$this->createGalleryRss();break;
              }
              //return $xml;
          }
          
          // 
          function createNewsRss()
          {
            $myRSS = new Socnet_RSS($this->title,$this->link,$this->descr,"http://".BASE_HTTP_HOST);
            $table = 'news';
            
            $sql = $this->_db->select()
    				->from('news')
    				->joinLeft(array('t2' => "news__categories"),"news_section_id = t2.cat_id")
    				->order("news_registration_date DESC")
    				->limit($this->num_items,0);
    		/*
         			$sql = $this->_db->select()
                    ->from($table)
                    ->where('1 = ? ',1)
                    ->order('registration_date DESC')
                    ->limit($count,$offset=0);
           */    				
        	$news = $this->_db->fetchAll($sql);
        	/*
        	echo "sql =- ".$sql->__toString();
        	dump($news);
        	exit;
        	-*/
            foreach ($news as $item)
        	{
         	  $myRSS->addItemCDATA($item['news_title'],$this->link.'/news/item/'.$item['cat_translit'].'/'.$item['id'].'.html',
         	  				  // substr(htmlentities($item['news_content'],ENT_NOQUOTES),0,200));
         	  				  $this->gw2_smart_wordwrap($item['news_content'],1000));
        	}
        	$myRSS->create("motofriends.ru.news.xml",'./upload/rss/','utf-8');
          }
          
          /**
           *  1) add image to rss
           *  2) ad description
           *
           */
          function createGalleryRss()
          {          	
            $this->title="Фотографии для друзей на www.".BASE_HTTP_HOST;
            $this->descr ="RSS-лента фотографий www.".BASE_HTTP_HOST;
           
            $myRSS = new Socnet_RSS($this->title,$this->link,$this->descr,"http://".BASE_HTTP_HOST);
            
            $url="http://".BASE_HTTP_HOST."/images/moto_logo.jpg";
            // $title="Фотографии для друзей на www.".BASE_HTTP_HOST;
            // $link="http://".BASE_HTTP_HOST;
            $myRSS->setChannelImage($url,$this->title,$this->link);
            $table = 'photos';
            
         	$sql = $this->_db->select()
                    ->from($table)
                    ->where('photos_public = ? ',1)
                    ->order('photos_registration_date DESC')
                    ->limit($this->num_items,$offset=0);
        	$photos = $this->_db->fetchAll($sql);
        	
        	foreach ($photos as $item)
        	{
        	  // user_id/album_id/photo_id_small.jpg
        	  $img_src = "http://".BASE_HTTP_HOST."/upload/user_photos/".$item['photos_user_id']."/".
        	             $item['photos_album_id']."/".md5($item['id']).'_small.jpg';
        	             
              $myRSS->socnet_addItemWithImage($item['photos_title'],
        	  // $this->link.'/albums/photo/id/'.$item['photos_user_id'].'/'.$item['photos_album_id']."/",$item['photos_description'],$img_src);
        	  $this->link.'/albums/photo/id/'.$item['id'],$item['photos_description'],$img_src);
 	          $myRSS->create("motofriends.ru.photos.xml",'./upload/rss/','utf-8');
        	}
/*
<item> 
<title>title</title>
<link>http://goodyear.colesa.ru/news/1096.html</link>
<description><![CDATA[<a href="http://goodyear.colesa.ru/news/1096.html"  border="0"  title="Грузовые шины Goodyear с применением технологии Fuel Max получают сертификацию EPA"><img src="http://www.colesa.ru/images/news_img/goodyear-nm1-24077.jpg" align=left style="margin:0px 7px 7px 7px;border:1px solid black;" ></a> DESCR SmartWay.]]></description>
<pubDate>Tue, 24 Jul 2007 06:07:15 +0400</pubDate>
<guid isPermaLink="true">http://goodyear.colesa.ru/news/1096.html</guid>
</item>	*/
        }
    }
?>