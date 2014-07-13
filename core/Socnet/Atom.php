<?
/**
 *  Create Atom for the news and for the photos
 *
 *  get some last data ...
 */
class Socnet_Atom extends Socnet_Data_Entity {

    public $feedArray;

	public function __construct()
	{
	   $this->_db = Zend::registry("DB");

	   $this->feedArray = array(
			'title' => 'cool title',
			'link' => 'http://www.socnet.my/10/atom',
			'lastUpdate' => strftime("%Y-%m-%d %H:%M:%S",time()),
			'charset' => 'utf-8',
			'description' => 'Descr',
			'author' => 'Konan',
			'email' => 'konan@biz.by',
			'copyright' => 'Antalika.com all rights reserved',
			'generator' => 'Zend Framework Zend_Feed',
			'language' => 'en',
			'entries' => array()
		);
	}
	/////////////////////////////////////////////////////
	// Do it YourSelf
	// prepare an array that our feed is based on
	/**
	 *  Great description is here...
	 *
	 *  @return unknown
	 */
	public function createAtom()
	{
	    /*
		   $id = $this->_getParam('blog', 0);
		   // get data
		$objects = new Objects();
		$blog = $objects->find($id)->current();
		if (!$blog){
			return $this->_forward('error');
		}
		*/
		// $posts = $objects->getRecentPosts($id);
		/*
		// prepare an array that our feed is based on
		$feedArray = array(
			'title' => $blog->title,
			'link' => 'http://www.alexatnet.com/blog/' . $id . '/atom',
			'lastUpdate' => (0 == $posts->count() ? date('c', strtotime()) : date('c')),
			'charset' => 'utf-8',
			'description' => $blog->description,
			'author' => 'Alexander Netkachev',
			'email' => 'alexander.netkachev@gmail.com',
			'copyright' => 'Alexander Natkachev, all rights reserved',
			'generator' => 'Zend Framework Zend_Feed',
			'language' => 'en',
			'entries' => array()
		);
	   */
		$size = 10;//Set size externally

		$sql  = "SELECT id,title,content,registration_date FROM news WHERE 1 ORDER BY
		                                                   registration_date DESC LIMIT 0,$size";

		$items = $this->_db->fetchAll($sql);
		$id    = 1;

		//
		foreach ($items as $item)
		{
		   $this->feedArray['entries'][] = array (
		   		    'title' => $item['title'],
    				'link' => 'http://'.BASE_HTTP_HOST.'/news/viewItem/' . $item['id'] .'/',
    				'description' => substr($item['content'],0,150),
    				'lastUpdate'  => $item['registration_date'],
    				'content'     => $item['content']
    		);
		}

		/*
		  << === ----- === ---- ===== ---- =====[0]--->>
    		FOREACH ($posts as $post)
    		{
    			$feedArray['entries'][] = array(
    				'title' => $post->title,
    				'link' => 'http://www.alexatnet.com/blog/' . $id . '/'
    					. date('Y/m/d', strtotime($post->updated)) . '/'
    					. $post->name,
    				'description' => $post->description,
    				'lastUpdate' => strtotime($post->updated),
    				'content' => $post->content
    			)
    		}
		*/
		// create feed document
		// $feed = Zend_Feed::importArray($this->feedArray, 'atom');
		// adjust created DOM document
		foreach ($feed as $entry)
		{
		  $element = $entry->summary->getDOM();
		  // Modify summary DOM node
		}
		// send feed XML to client

		echo $feed->send();
	}
}

?>