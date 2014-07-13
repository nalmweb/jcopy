<?php
require_once(SOCNET_DIR.'Interface/iAvatar.php');

class Socnet_User_Avatar extends Socnet_Data_Entity implements Socnet_Interface_iAvatar
{
    private $id;
    private $userId;
    private $byDefault;
    private $path;

    private $width  = 0;
    private $height = 0;
    private $border = 1;

    /**
     * @todo $border always is 1 - no processing while new avatar created.
     */

    /**
     * Constructor.
     */
    public function __construct($value = null)
    {
        parent::__construct('user__avatars', array(
        'id'        => 'id',
        'user_id'   => 'userId',
        'bydefault' => 'bydefault'));
        if ($value === 0) {
        	$this->id = 0;
        } else {
	        $this->load($value);
	        $this->path = ( $this->id !== null ) ? '/upload/user_avatars/'.md5($this->userId.$this->id) : null ;//http path
        }
    }

    /**
     * delete avatar
     */
    public function delete()
    {
        $avatars = glob(DOC_ROOT.'/upload/user_avatars/'.md5($this->userId.$this->id).'*.*');
        if ( sizeof($avatars) != 0 ) {
            foreach ( $avatars as $avatar ) unlink($avatar);
        }
        parent::delete();
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function setId($newValue)
    {
        $this->id = $newValue;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($newValue)
    {
        $this->userId = $newValue;
        return $this;
    }

    public function getByDefault()
    {
        return $this->byDefault;
    }

    public function setByDefault($newValue)
    {
        $this->byDefault = $newValue;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getWidht()
    {
        return $this->width;
    }

    public function setWidth($newValue)
    {
        $this->width = $newValue;
        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($newValue)
    {
        $this->height = $newValue;
        return $this;
    }

    public function getBorder()
    {
        return $this->border;
    }

    public function setBorder($newValue)
    {
        $this->border = $newValue;
        return $this;
    }

    public function getImage()
    {
        if (file_exists('.'.$this->path.'_orig.jpg')){//if avatar really uploaded

            //            if (!$this->width || !$this->height){ // if width or height not set - return _orig file
            //                return $this->path.'_orig.jpg';
            //            } else {//return existing file
            //
            if (file_exists('.'.$this->path.'_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg'))
            {
                return $this->path.'_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg';
            } else {// create new file

                $r0 = Socnet_Image_Thumbnail::makeThumbnail('.'.$this->getPath().'_orig.jpg', '.'.$this->getPath().'_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg', $this->width, $this->height, true);
                return $this->path.'_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg';
            }
            //            }
        } else { //check and create new 'noimage' avatar
            //            if (!$this->width || !$this->height){ // if width or height not set - return main noimage file
            //                return '/upload/user_avatars/noimage.jpg';
            //            } else { //return existing file

            if (file_exists('./upload/user_avatars/noimage_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg'))
            {
                return '/upload/user_avatars/noimage_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg';
            } else { //create new noimage file

                $r0 = Socnet_Image_Thumbnail::makeThumbnail('./upload/user_avatars/noimage.gif', './upload/user_avatars/noimage_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg', $this->width, $this->height, true);
                return '/upload/user_avatars/noimage_x'.$this->width.'_y'.$this->height.'_b'.$this->border.'.jpg';
            }
            //            }
        }
    }

    /**
     * Проверяет определен ли объект
     * @return bool
     */
    public function isExists()
    {
        if ( $this->getId() !== null ) return true;
        else return false;
    }
    /**
     * Возвращает путь к small аватар
     * @return string
     */
    public function getSmall()
    {
        return $this->setWidth(48)->setHeight(48)->setBorder(1)->getImage();
    }
    
    public function getPic()
    {
        return $this->setWidth(16)->setHeight(16)->setBorder(0)->getImage();
    }
    
   /**
	* @param:int $user_id 
	* @return:avatar path by user id. 
	* @comment:No need to create user if only avatar is needed (comments for inst.) 
	*/
	function getSmallById($user_id)
	{
	   $sql =$this->_db->select("user__avatars","id")->from("user__avatars")->where("user_id =?",$user_id)->where("bydefault=1"); 	
	   $avatar_id = $this->_db->fetchCol($sql);
	   
	   if(!empty($avatar_id))
	   	 $avatar_id = $avatar_id[0];
	   
	   $this->path = ( $this->id !== null ) ? '/upload/user_avatars/'.md5($user_id.$avatar_id) : null ;
	    	 
	   if (file_exists(getcwd().$this->path.'_small.jpg')){
	       return $this->path.'_small.jpg';
	   }else{
	       return '/images/no_image_avatar.gif';
	   }
	}
    
    
    /**
     * Возвращает путь к medium аватар
     * @return string
     */
    public function getMedium()
    {
        return $this->setWidth(150)->setHeight(150)->setBorder(1)->getImage();
    }
    /**
     * Возвращает путь к big аватар
     * @return string
     */
    public function getBig()
    {
        return $this->getImage();
    }

}
