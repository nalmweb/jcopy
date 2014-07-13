<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet
 * @copyright  Copyright (c) 2006
 */

/**
 *
 *
 */
class Socnet_Artifacts
{
	/**
	 * Db connection object.
	 *
	 * @var object
	 */
    public $_db;
    public $owner;
    public $owner_type;
    /**
     * Конструктор
     */
    public function __construct($owner)
    {
        $this->_db = Zend::registry("DB");
        $this->owner = $owner;
        if ( $owner instanceof Socnet_User) {
            $this->owner_type = 'user';
        } elseif ( $owner instanceof Socnet_Group) {
            $this->owner_type = 'group';
        } elseif ( $owner instanceof Socnet_Group_FamilyGroup) {
            $this->owner_type = 'group';
        }
    }
	/**
	 * Unshare all artifacts from current group for artifact owner (group or user)
	 * @param int $group_id
	 * @todo аншарить все артифакты, сделано только для документов
	 */
    public function unshareAllArtifactsFromGroup($group_id)
    {
        $this->unshareAllDocumentsFromGroup($group_id);
        $this->unshareAllGalleriesFromGroup($group_id);
        $this->unshareAllListsFromGroup($group_id);
        $this->unshareAllEventsFromGroup($group_id);
    }
	/**
	 * Unshare all artifacts from current group for artifact owner (group or user)
	 * @param int $group_id
	 * @todo аншарить все артифакты, сделано только для документов
	 */
    public function unshareAllArtifactsFromUser($user_id)
    {
        $this->unshareAllDocumentsFromUser($user_id);
        $this->unshareAllGalleriesFromUser($user_id);
        $this->unshareAllListsFromUser($user_id);
        $this->unshareAllEventsFromUser($user_id);
    }
    //----------------------------------------------------
    //
    //  DOCUMENTS
    //
    //----------------------------------------------------
	/**
	 * Return count of documents
	 * @param int $excludeAdult - filter adult marked documents, or not
	 * @package int $currentUser - current logined user (use for exclude adult)
	 * @return int
	 * @
	 */
    public function getDocumentsCount($excludeAdult = 0, $currentUser = null)
	{
	    $select = $this->_db->select();
        $select->from('view_documents__list', 'count(id) as count');
        $select->where('owner_type = ?', $this->owner_type);
        $select->where('owner_id = ?', $this->owner->id);


        if ($excludeAdult != 0 && $currentUser->adultFilter !=0 ){
            $select->where('((adult = 0) OR (adult = 1 AND creator_id = ?))', $currentUser->id);
        }
        $doc_count = $this->_db->fetchOne($select);
        return $doc_count;
	}
	/**
	 * Return list of documents
	 * @param int $page
	 * @param int $size
	 * @param int $excludeAdult - filter adult marked documents, or not
	 * @param int $currentUser - current logined user (use for exclude adult)
	 * @return array of Socnet_Document_Item
	 */
    public function getDocumentsList($page = null, $size = 50, $excludeAdult = 0, $currentUser = null)
    {
        $select = $this->_db->select();
        $select->from('view_documents__list', 'id');
        $select->where('owner_type = ?', $this->owner_type);
        $select->where('owner_id = ?', $this->owner->id);
        $select->order('original_name');

        if ($excludeAdult != 0 && $currentUser->adultFilter != 0){
            $select->where('((adult = 0) OR (adult = 1 AND creator_id = ?))', $currentUser->id);
        }

        if ($page !== null) {
            $select->limitPage($page, $size);
        }
    	$docs = $this->_db->fetchCol($select);
    	foreach ($docs as &$doc) $doc = new Socnet_Document_Item($doc);
    	return $docs;
    }
    /**
     * Return assoc array of values 'id', 'original_name as originalName'
     * @return array
     */
	public function getDocumentsListAssoc()
	{
		/**
		 * @todo Add $excludeAdult if need in future
		 */

	    $select = $this->_db->select()
		                    ->from('documents__items', array('id', 'original_name as originalName'))
                            ->where('owner_type = ?', $this->owner_type)
                            ->where('owner_id = ?', $this->owner->id);
		$docs = $this->_db->fetchPairs($select);

		return $docs;
	}
	/**
	 * Return documents shared to current group for artifact owner (group or user)
	 * @param int $group_id
	 * @return array of Socnet_Document_Item
	 */
	public function getDocumentsListSharedToGroup($group_id)
	{
	    $select = $this->_db->select();
	    $select->from('documents__sharing as zds', 'zds.document_id')
	           ->joininner('documents__items as zdi', 'zdi.id = zds.document_id')
	           ->where('zds.owner_type =?', 'group')
	           ->where('zds.owner_id =?', $group_id)
	           ->where('zdi.owner_type =?', $this->owner_type)
	           ->where('zdi.owner_id =?', $this->owner->id);
	    $docs = $this->_db->fetchCol($select);
	    foreach ($docs as &$doc) $doc = new Socnet_Document_Item($doc);
	    return $docs;
	}
	/**
	 * Return documents shared to current user for artifact owner (group or user)
	 * @param int $user_id
	 * @return array of Socnet_Document_Item
	 */
	public function getDocumentsListSharedToUser($user_id)
	{
	    $select = $this->_db->select();
	    $select->from('documents__sharing as zds', 'zds.document_id')
	           ->joininner('documents__items as zdi', 'zdi.id = zds.document_id')
	           ->where('zds.owner_type =?', 'user')
	           ->where('zds.owner_id =?', $user_id)
	           ->where('zdi.owner_type =?', $this->owner_type)
	           ->where('zdi.owner_id =?', $this->owner->id);
	    $docs = $this->_db->fetchCol($select);
	    foreach ($docs as &$doc) $doc = new Socnet_Document_Item($doc);
	    return $docs;
	}
	/**
	 * Unshare all documents from current group for artifact owner (group or user)
	 * @param int $group_id
	 */
	public function unshareAllDocumentsFromGroup($group_id)
	{
	    $docs = $this->getDocumentsListSharedToGroup($group_id);
        foreach ($docs as &$doc) {
            $doc->unshareDocument('group', $group_id);
        }
	}
	/**
	 * Unshare all documents from current user for artifact owner (group or user)
	 * @param int $user_id
	 */
	public function unshareAllDocumentsFromUser($user_id)
	{
	    $docs = $this->getDocumentsListSharedToUser($user_id);
        foreach ($docs as &$doc) {
            $doc->unshareDocument('user', $user_id);
        }
	}
    //----------------------------------------------------
    //
    //  LISTS
    //
    //----------------------------------------------------
	/**
	 * Возвращает количество листов
	 * @return int
	 */
    public function getListsCount()
	{
        $select = $this->_db->select()
                      ->from('lists__items', 'count(id) as count')
                      ->where('owner_type = ?', $this->owner_type)
                      ->where('owner_id = ?', $this->owner->id);
        $list_count = $this->_db->fetchOne($select);
        return $list_count;
	}
	/**
	 * Возвращает список листов
	 * @param int $page
	 * @param int $size
	 * @return array of Socnet_List_Item
	 */
    public function getListsList($page = null, $size = 50)
    {
        $select = $this->_db->select()
                           ->from('lists__items', 'id')
                           ->where('owner_type = ?', $this->owner_type)
                           ->where('owner_id = ?', $this->owner->id);
        if ($page !== null) {
            $select->limitPage($page, $size);
        }
    	$lists = $this->_db->fetchCol($select);
    	foreach ($lists as &$list) $list = new Socnet_List_Item($list);
    	return $lists;
    }
	/**
	 * Unshare all lists from current group for artifact owner (group or user)
	 * @param int $group_id
	 * @todo Реализовать
	 */
	public function unshareAllListsFromGroup($group_id)
	{

	}
	/**
	 * Unshare all lists from current user for artifact owner (group or user)
	 * @param int $user_id
	 * @todo Реализовать
	 */
	public function unshareAllListsFromUser($user_id)
	{

	}
    //----------------------------------------------------
    //
    //  GALLERIES
    //
    //----------------------------------------------------
	/**
	 * Return count of all galleries
	 * @param $withoutShared -
	 * @return int
	 */
	public function getGalleriesCount($withoutShared = false)
	{
	    $select = $this->_db->select();
	    $select->from('view_groups__gallery_list', 'count(id) as count');
	    $select->where('owner_id = ?', $this->owner->id);
	    $select->where('owner_type =?', $this->owner_type);
	    if ($withoutShared == true){
	        $select ->where('share = 0');
	    }

	    $galleries_count = $this->_db->fetchOne($select);

	    return $galleries_count;
	}
	/**
	 * Return list of gallery objects for user or group
	 * @param int $page - if null - return all galleries
	 * @param int $size
	 * @return array of Socnet_Photo_Gallery objects
	 */
	public function getGalleriesList($page = null, $size = 50, $withoutShared = false)
	{
	    $select = $this->_db->select()
	                   ->from('view_groups__gallery_list', 'id')
	                   ->where('owner_id = ?', $this->owner->id)
	                   ->where('owner_type = ?', $this->owner_type);
	    if ($withoutShared === true){
	        $select->where('share = 0');
	    }

	    if ( $page !== null ) {
	        $select->limitPage($page, $size);
	    }
	    $galleries = $this->_db->fetchCol($select);
	    foreach ($galleries as &$gallery) $gallery = new Socnet_Photo_Gallery($gallery);
	    return $galleries;
	}


    /**
     * return assoc of all galleries (id-title)
     * @return array of (ID, Title)
     */

    public function getGalleriesListAssoc($withoutShared = false)
    {
        $select = $this->_db->select();
        $select->from('view_groups__gallery_list', array('id', 'title'));
        $select->where('owner_id = ?', $this->owner->id);
        $select->where('owner_type = ?', $this->owner_type);
        if ($withoutShared == true){
            $select ->where('share = 0');
        }
        $galleries = $this->_db->fetchPairs($select);

        return $galleries;
    }

     /**
     * return assoc of all shared galleries (id-title) for groups only
     * @return array of (ID, Title)
     */

    public function getGroupSharedGalleriesListAssoc()
    {
        $select = $this->_db->select()
                       ->from('view_groups__gallery_list', array('id', 'title'))
	                   ->where('owner_id = ?', $this->owner->id)
	                   ->where('owner_type = "group"')
	                   ->where('share = 1');
        $galleries = $this->_db->fetchPairs($select);

        return $galleries;
    }

     /**
     * return assoc of all shared galleries (id-title) for users only
     * @return array of (ID, Title)
     */

    public function getUserSharedGalleriesListAssoc()
    {
        $select = $this->_db->select()
                       ->from('view_groups__gallery_list', array('id', 'title'))
	                   ->where('owner_id = ?', $this->owner->id)
	                   ->where('owner_type = "user"')
	                   ->where('share = 1');
        $galleries = $this->_db->fetchPairs($select);

        return $galleries;
    }

    /**
     * Return size of all galleries for current owner
     *
     * @param string $unit (byte, kb, mb)
     * @return int size
     */
    public function getGalleriesSize($unit = "byte")
    {
        $select = $this->_db->select()
                           ->from('view_groups__gallery_list', 'id')
                           ->where('owner_id = ?', $this->owner->id)
                           ->where('owner_type = ?', $this->owner_type);

        $galleries = $this->_db->fetchAll($select);
        $size = 0;

        foreach ($galleries as &$gallery)
    	{
    	    $gallery = new Socnet_Photo_Gallery($gallery);
    	    $size += $gallery->getGallerySize();
    	}
    	unset ($galleries);

    	if ($unit == "kb")    $size = $size/1024;
    	if ($unit == "mb")    $size = $size/1024/1024;

    	return floor($size);
    }
	/**
	 * Return galleries shared to current group for artifact owner (group or user)
	 * @param int $group_id
	 * @return array of Socnet_Photo_Gallery
	 */
	public function getGalleriesListSharedToGroup($group_id)
	{
	    $select = $this->_db->select();
	    $select->from('galleries__sharing as zgs', 'zgs.gallery_id')
	           ->joininner('galleries__items as zgi', 'zgi.id = zgs.gallery_id')
	           ->where('zgs.owner_type =?', 'group')
	           ->where('zgs.owner_id =?', $group_id)
	           ->where('zgi.owner_type =?', $this->owner_type)
	           ->where('zgi.owner_id =?', $this->owner->id);
	    $galleries = $this->_db->fetchCol($select);
	    foreach ($galleries as &$gallery) $gallery = new Socnet_Photo_Gallery($gallery);
	    return $galleries;
	}
	/**
	 * Return galleries shared to current user for artifact owner (group or user)
	 * @param int $user_id
	 * @return array of Socnet_Document_Item
	 */
	public function getGalleriesListSharedToUser($user_id)
	{
	    $select = $this->_db->select();
	    $select->from('galleries__sharing as zgs', 'zgs.gallery_id')
	           ->joininner('galleries__items as zgi', 'zgi.id = zgs.gallery_id')
	           ->where('zgs.owner_type =?', 'user')
	           ->where('zgs.owner_id =?', $user_id)
	           ->where('zgi.owner_type =?', $this->owner_type)
	           ->where('zgi.owner_id =?', $this->owner->id);
	    $galleries = $this->_db->fetchCol($select);
	    foreach ($galleries as &$gallery) $gallery = new Socnet_Photo_Gallery($gallery);
	    return $galleries;
	}
	/**
	 * Unshare all galleries from current group for artifact owner (group or user)
	 * @param int $group_id
	 */
	public function unshareAllGalleriesFromGroup($group_id)
	{
	    $galleries = $this->getGalleriesListSharedToGroup($group_id);
        foreach ($galleries as &$gallery) {
            $gallery->unshareGalleryFromGroup($group_id);
        }
	}
	/**
	 * Unshare all galleries from current user for artifact owner (group or user)
	 * @param int $user_id
	 */
	public function unshareAllGalleriesFromUser($user_id)
	{
	    $galleries = $this->getGalleriesListSharedToUser($user_id);
        foreach ($galleries as &$gallery) {
            $gallery->unshareGalleryFromUser($user_id);
        }
	}

    //----------------------------------------------------
    //
    //  CALENDARS
    //
    //----------------------------------------------------

    /**
     * get events count
     *
     * @return unknown
     */
    public function getEventsCount()
	{
        $select = $this->_db->select()
                      ->from('calendar__events', 'count(id)');
                     // ->where('owner_type = ?', $this->owner_type)
                     // ->where('owner_id = ?', $this->owner->id);
        return $this->_db->fetchOne($select);
	}
	/**
	 * get events list
	 * @param int $page
	 * @param int $size
	 * @return array of Socnet_Photo_Gallery
	 */
    public function getEventsList($page = 1, $size = 50)
    {
        $select = $this->_db->select()
                           ->from('calendar__events', 'id')
                         //  ->where('owner_type = ?', $this->owner_type)
                         //  ->where('owner_id = ?', $this->owner->id)
                           ->limitPage($page, $size);
    	$events = $this->_db->fetchCol($select);
    	foreach ($events as &$event) $event = new Socnet_Event($event);
    	return $events;
    }
	/**
	 * Unshare all events from current group for artifact owner (group or user)
	 * @param int $group_id
	 * @todo Реализовать
	 */
	public function unshareAllEventsFromGroup($group_id)
	{

	}
	/**
	 * Unshare all events from current user for artifact owner (group or user)
	 * @param int $user_id
	 * @todo Реализовать
	 */
	public function unshareAllEventsFromUser($user_id)
	{

	}

	/**
	 * Return object list of all active bookmark services
	 *
	 * @return array of Bookmark objects
	 */

	public function getBookmarkServicesList(){
	    $select = $this->_db->select();
	    $select->from('bookmark__services', 'id');
	    $select->where('active = 1');
	    $bookmarkServices = $this->_db->fetchCol($select);
	    foreach ($bookmarkServices as &$service) $service = new Socnet_Bookmark_Item($service);
	    return $bookmarkServices;
	}

	/**
	 * Not used now
	 *
	 */
	public function getBookmarkServicesListAssoc(){

	}

    //
    //  Message Board
    //
    //----------------------------------------------------

    /**
     * get list of boards
     * @return array of objects
     */
    public function getBoardsList($page = 1, $size = 10)
    {
        $where = $this->_db->quoteInto('group_id=?', $this->owner->id);
        $sql = $this->_db->select()->from('forum__boards', 'id')->where($where)->limitPage($page, $size);
        $boards = $this->_db->fetchCol($sql);
        foreach($boards as &$board){
            $board = new Socnet_Forum_Board($board);
            $board->setForum($this);
        }
        return $boards;
    }

    /**
     * get boards number
     * @return int
     */
    public function getBoardsNum()
    {
        $where = $this->_db->quoteInto('forum_id=?', $this->owner->id);
        $sql = $this->_db->select()->from('forum__boards', 'COUNT(id)')->where($where);
        return $this->_db->fetchOne($sql);
    }


}