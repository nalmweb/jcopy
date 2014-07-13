<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_User
 * @copyright  Copyright (c) 2007
 */

/**
 * Base class for Users
 *
 */
class Socnet_User extends Socnet_Data_Entity
{
    public $id;
    public $login;
    public $pass;
    public $gender;
    public $birthday;
    public $birthdayPrivate;
    public $nikname;
    public $firstname;
    public $middlename;
    public $admin;
    public $autohouse;
    public $lastname;
    public $viewAs;
    public $post;
    public $intro;
    public $headline;
    public $registerCode;
    public $registerDate;
    public $lastAccessDate;
    public $status;
    public $cityId;
    public $company;
    public $metroId;
    public $latitude;
    public $longitude;
    public $zoom;
    public $street;
    public $build;
    public $apartment;
    public $age= null;
    public $profitId;
    public $skype;
    public $icq;
    public $msn;
    public $livejournal;
    public $homepage;
    public $phone;
    public $experience;
    public $user_adv_path;
    public $bikeId;
    
    // for comments:
    public  $comment_id;
    public  $num_comments;
    private $comments_tname;

    private $Avatar             = null;
    private $City               = null;
    private $Metro              = null;
    private $Country            = null;
    private $Contacts           = null;
    private $Profit             = null;
    private $Bike               = null;
    private $helmetIcon         = null;
    private $helmetShadowIcon   = null;
    private $UserPath           = null;
    private $AuthResult         = null;
    private $isUsedNamedPath    = false;

    public function __construct($key = null, $val = null)
    {
        parent::__construct('user');

        $this->addField('id');
        $this->addField('login');
        $this->addField('pass');
        $this->addField('gender');
        $this->addField('birthday');
        $this->addField('birthday_private', 'birthdayPrivate');
        $this->addField('nikname');
        $this->addField('firstname');
        $this->addField('middlename');
        $this->addField('admin');
        $this->addField('autohouse');
        $this->addField('lastname');
        $this->addField('view_as', 'viewAs');
        $this->addField('intro');
        $this->addField('register_date', 'registerDate');
        $this->addField('register_code', 'registerCode');
        $this->addField('last_access',   'lastAccessDate');
        $this->addField('status');
        $this->addField('city_id', 'cityId');
        $this->addField('metro_id', 'metroId');
        $this->addField('latitude');
        $this->addField('longitude');
        $this->addField('zoom');
        $this->addField('company');
        $this->addField('post');
        $this->addField('skype');
        $this->addField('icq');
        $this->addField('msn');
        $this->addField('livejournal');
        $this->addField('homepage');
        $this->addField('phone');
        $this->addField('street');
        $this->addField('build');
        $this->addField('apartment');
        $this->addField('intro');
        $this->addField('profit_id','profitId');
        $this->addField('experience');
        $this->addField('bike_id', 'bikeId');
        
        //comm
        //$this->addField('comment_id');
        //$this->addField('num_comments');
        //$this->comments_tname = 'comment__user';

        if ($key !== null){
           $this->pkColName = $key;
           $this->loadByPk($val);
        }

        $this->user_adv_path = null;
        if ( $this->id !== null ) {
           $this->user_adv_path = 'http://'.BASE_HTTP_HOST.'/users/'.$this->id;
           $this->age = $this->getAge();
        }
    }
/**
     * @return unknown
     */
    public function getAdmin () { return $this->admin; }

/**
     * @param unknown_type $admin
     */
    public function setAdmin ($admin) { $this->admin = $admin; return $this;}

  /**
   * @return unknown
   */
  public function getAutohouse () { return $this->autohouse; }

  /**
   * @param unknown_type $admin
   */
  public function setAutohouse ($autohouse) { $this->autohouse = $autohouse; return $this;}

/**
     * @param unknown_type $age
     */
    //public function setAge ($age) { $this->age = $age; return $this;}

/**
     * @return unknown
     */
    public function getApartment () { return $this->apartment; }

/**
     * @param unknown_type $apartment
     */
    public function setApartment ($apartment) { $this->apartment = $apartment; return $this;}

/**
     * @return unknown
     */
    public function getAuthResult () { return $this->authResult; }

/**
     * @param unknown_type $AuthResult
     */
    public function setAuthResult ($authResult) { $this->authResult = $authResult; return $this;}

/**
     * @return unknown
     */
    public function getBirthday () { return $this->birthday; }

/**
     * @param unknown_type $birthday
     */
    public function setBirthday ($birthday) { $this->birthday = $birthday; return $this;}
/**
     * @return unknown
     */
    public function getBirthdayPrivate () { return $this->birthdayPrivate; }

/**
     * @param unknown_type $birthdayPrivate
     */
    public function setBirthdayPrivate ($birthdayPrivate) { $this->birthdayPrivate = $birthdayPrivate; return $this;}


/**
     * @return unknown
     */
    public function getBuild () { return $this->build; }

/**
     * @param unknown_type $build
     */
    public function setBuild ($build) { $this->build = $build; return $this;}

/**
     * @return unknown
     */
    public function getCityId () { return $this->cityId; }

/**
     * @param unknown_type $city_id
     */
    public function setCityId ($cityId) { $this->cityId = $cityId; return $this;}

/**
     * @return unknown
     */
    public function getCompany () { return $this->company; }

/**
     * @param unknown_type $company
     */
    public function setCompany ($company) { $this->company = $company; return $this;}

/**
     * @return unknown
     */
    public function getEntityTypeId () { return $this->entityTypeId; }

/**
     * @param unknown_type $EntityTypeId
     */
    public function setEntityTypeId ($entityTypeId) { $this->entityTypeId = $entityTypeId; return $this;}

/**
     * @param unknown_type $experience
     */
   // public function setExperience ($experience) { $this->experience = $experience; return $this;}

/**
     * @return unknown
     */
    public function getFirstname () { return $this->firstname; }

/**
     * @param unknown_type $firstname
     */
    public function setFirstname ($firstname) { $this->firstname = $firstname; return $this;}

/**
     * @return unknown
     */
    public function getGender () { return $this->gender; }

/**
     * @param unknown_type $gender
     */
    public function setGender ($gender) { $this->gender = $gender; return $this;}

/**
     * @return unknown
     */
    public function getHeadline () { return $this->headline; }

/**
     * @param unknown_type $headline
     */
    public function setHeadline ($headline) { $this->headline = $headline; return $this;}

/**
     * @return unknown
     */
    public function getHomepage () { return $this->homepage; }

/**
     * @param unknown_type $homepage
     */
    public function setHomepage ($homepage) { $this->homepage = $homepage; return $this;}

/**
     * @return unknown
     */
    public function getIcq () { return $this->icq; }

/**
     * @param unknown_type $icq
     */
    public function setIcq ($icq) { $this->icq = $icq; return $this;}

/**
     * @return unknown
     */
    public function getId () { return $this->id; }

/**
     * @param unknown_type $id
     */
    public function setId ($id) { $this->id = $id; return $this;}

/**
     * @return unknown
     */
    public function getIntro () { return $this->intro; }

/**
     * @param unknown_type $intro
     */
    public function setIntro ($intro) { $this->intro = $intro; return $this;}

/**
     * @return boolean
     */
    public function getIsExist () { return $this->isExist; }

/**
     * @param boolean $isExist
     */
    public function setIsExist ($isExist) { $this->isExist = $isExist; return $this;}

/**
     * @return unknown
     */
    public function getIsUsedNamedPath () { return $this->isUsedNamedPath; }

/**
     * @param unknown_type $isUsedNamedPath
     */
    public function setIsUsedNamedPath ($isUsedNamedPath) { $this->isUsedNamedPath = $isUsedNamedPath; return $this;}

/**
     * @return unknown
     */
    public function getLastAccessDate () { return $this->lastAccessDate; }

/**
     * @param unknown_type $lastAccessDate
     */
    public function setLastAccessDate ($lastAccessDate) { $this->lastAccessDate = $lastAccessDate; return $this;}

/**
     * @return unknown
     */
    public function getLastname () { return $this->lastname; }

/**
     * @param unknown_type $lastname
     */
    public function setLastname ($lastname) { $this->lastname = $lastname; return $this;}

/**
     * @return unknown
     */
    public function getLatitude () { return $this->latitude; }

/**
     * @param unknown_type $latitude
     */
    public function setLatitude ($latitude) { $this->latitude = $latitude; return $this;}

/**
     * @return unknown
     */
    public function getLivejournal () { return $this->livejournal; }

/**
     * @param unknown_type $livejournal
     */
    public function setLivejournal ($livejournal) { $this->livejournal = $livejournal; return $this;}

/**
     * @return unknown
     */
    public function getLogin () { return $this->login; }

/**
     * @param unknown_type $login
     */
    public function setLogin ($login) { $this->login = $login; return $this;}

/**
     * @return unknown
     */
    public function getLongitude () { return $this->longitude; }

/**
     * @param unknown_type $longitude
     */
    public function setLongitude ($longitude) { $this->longitude = $longitude; return $this;}

/**
     * @return unknown
     */
    public function getMetroId () { return $this->metroId; }

/**
     * @param unknown_type $metro_id
     */
    public function setMetroId ($metroId) { $this->metroId = $metroId; return $this;}

/**
     * @return unknown
     */
    public function getMiddlename () { return $this->middlename; }

/**
     * @param unknown_type $middlename
     */
    public function setMiddlename ($middlename) { $this->middlename = $middlename; return $this;}

/**
     * @return unknown
     */
    public function getMsn () { return $this->msn; }

/**
     * @param unknown_type $msn
     */
    public function setMsn ($msn) { $this->msn = $msn; return $this;}

/**
     * @param unknown_type $nikname
     */
    public function setNikname ($nikname) { $this->nikname = $nikname; return $this;}

/**
     * @return unknown
     */
    public function getPass () { return $this->pass; }

	/**
     * @param unknown_type $pass
     */
    public function setPass ($pass) { $this->pass = $pass; return $this;}

/**
     * @return unknown
     */
    public function getPhone () { return $this->phone; }

/**
     * @param unknown_type $phone
     */
    public function setPhone ($phone) { $this->phone = $phone; return $this;}

/**
     * @return unknown
     */
    public function getPost () { return $this->post; }

/**
     * @param unknown_type $post
     */
    public function setPost ($post) { $this->post = $post; return $this;}

/**
     * @return unknown
     */
    public function getProfitId () { return $this->profitId; }

/**
     * @param unknown_type $profitId
     */
    public function setProfitId ($profitId) { $this->profitId = $profitId; return $this;}

/**
     * @return array
     */
    public function getRecord () { return $this->record; }

/**
     * @param array $record
     */
    public function setRecord ($record) { $this->record = $record; return $this;}

/**
     * @return unknown
     */
    public function getRegisterCode () { return $this->registerCode; }

/**
     * @param unknown_type $registerCode
     */
    public function setRegisterCode ($registerCode) { $this->registerCode = $registerCode; return $this;}

/**
     * @return unknown
     */
    public function getRegisterDate () { return $this->registerDate; }

/**
     * @param unknown_type $registerDate
     */
    public function setRegisterDate ($registerDate) { $this->registerDate = $registerDate; return $this;}

/**
     * @return unknown
     */
    public function getSkype () { return $this->skype; }

/**
     * @param unknown_type $skype
     */
    public function setSkype ($skype) { $this->skype = $skype; return $this;}

/**
     * @return unknown
     */
    public function getStatus () { return $this->status; }

/**
     * @param unknown_type $status
     */
    public function setStatus ($status) { $this->status = $status; return $this;}

/**
     * @return unknown
     */
    public function getStreet () { return $this->street; }

/**
     * @param unknown_type $street
     */
    public function setStreet ($street) { $this->street = $street; return $this;}

/**
     * @return unknown
     */
    public function getUser_adv_path () { return $this->user_adv_path; }

/**
     * @param unknown_type $user_adv_path
     */
    public function setUser_adv_path ($user_adv_path) { $this->user_adv_path = $user_adv_path; return $this;}
/**
     * @return unknown
     */
    public function getViewAs () { return $this->viewAs; }

/**
     * @param unknown_type $viewAs
     */
    public function setViewAs ($viewAs) { $this->viewAs = $viewAs; return $this;}


/**
     * @return unknown
     */
    public function getZoom () { return $this->zoom; }

/**
     * @param unknown_type $zoom
     */
    public function setZoom ($zoom) { $this->zoom = $zoom; return $this;}


    public function setContacts()
    {
        $select = $this->_db->select();
        $select->from('user__contacts', 'id')
               ->where('user_id = ?', $this->getId());
        $res = $this->_db->fetchOne($select);
        $this->Contacts = new Socnet_User_Contacts($res);
    }

    public function getContacts()
    {
        if ($this->Contacts === null) {
            $this->setContacts();
        }
        return $this->Contacts;
    }

    public function getMetro()
    {
        if ($this->Metro === null)
        {
            $this->setMetro();
        }
        return $this->Metro;
    }

    public function setMetro()
    {
        $this->Metro = new Socnet_Location_Metro($this->getMetroId());
        return false;
    }

    public function getProfit() {
        if ($this->Profit === null) {
            $this->setProfit();
        }
        return $this->Profit;
    }
    
    public function getNikname(){
    	return $this->nikname;
    }	

    public function setProfit() {
        if ($this->getProfitId() != 0 && null !== $this->getProfitId())
            $this->Profit = new Socnet_User_Profit($this->getProfitId());

        return false;
    }

    public function hasAccess(Socnet_User $user) {
    	if (!$this->admin){
            if (defined('ADMIN_MODE')) return false;
            if (null === $this->id && null === $user->id) return false;
            if ($this->id === $user->id) return true;
        } else return true;

        return false;
    }

    public function setUserPath()
    {
        if ( $this->id !== null ) {
            if (preg_match('/^([a-zA-Z0-9]){1,}$/mi', $this->login, $match) && USE_USER_PATH ) {
                $this->UserPath = 'http://'.BASE_HTTP_HOST.'/users/';
                $this->isUsedNamedPath = true;
            }
        }
        if ( $this->UserPath === null ) {
            $this->UserPath = 'http://'.BASE_HTTP_HOST.'/users/';
        }
    }

    public function getUserPath( $action = null, $withslash = true )
    {
        if ( $this->UserPath === null ) {
            $this->setUserPath();
        }
        if ( $action !== null ) {
           // $action .= '/';
            if ( $this->isUsedNamedPath == false ) {
                return ($withslash) ? $this->UserPath.$action.'/userid/'.$this->id.'/' : $this->UserPath.$action.'/userid/'.$this->id;
            } else {
                return ($withslash) ? $this->UserPath.$action.'/' : $this->UserPath.$action;
            }
        } else {
            return $this->UserPath;
        }
    }

    public function setAvatar()
    {
        $select = $this->_db->select();
        $select->from('user__avatars', 'id')
               ->where('user_id = ?', $this->id)
               ->where('bydefault = ?', 1);
        $res = $this->_db->fetchOne($select);
        $this->Avatar = new Socnet_User_Avatar($res);
    }

    public function getAvatar()
    {
        if ( $this->Avatar === null ) {
           $this->setAvatar();
        }
        return $this->Avatar;
    }

    public function setCity()
    {
        $this->City = new Socnet_Location_City($this->getCityId());
    }

    public function getCity()
    {
        if ( $this->City === null ) {
            $this->setCity();
        }
        return $this->City;
    }

    public function setCountry()
    {
        $this->Country = $this->getCity()->getCountry();
    }

    public function getCountry()
    {
        if ( $this->Country === null ) {
            $this->setCountry();
        }
        return $this->Country;
    }

    public function isAuthenticated()
    {
        return (isset($_SESSION['user_id'])) ? true : false ;
    }

    public static function authenticate($login,$password)
    {
        $auth = Zend_Registry::get("Auth");
        $auth->setIdentity($login)
             ->setCredential($password);

        $AuthResult = $auth->authenticate();
        
        if ($AuthResult->isValid()) {
            //Socnet_Http_Cookie::setCookieStatic('SOCNET_USER', $user->id, Socnet_Session::getExpirie());
            Socnet_Http_Cookie::setCookieStatic('SOCNET_LOGIN', $login, Socnet_Session::getExpirie());
            Socnet_Http_Cookie::setCookieStatic('SOCNET_PASS', $password, Socnet_Session::getExpirie());
            return true;
        }
        return false;
    }

    /**
     * Возвращает строковое значение, последней активности пользователя.
     * @return String
     */
    public function getLastOnline(){
        if ($this->lastOnline === null || $this->lastOnline == "Online") {
            $oDate = new Zend_Date();
            $_now = $oDate->get();
            $_last = strtotime($this->lastAccessDate);

            $_sec = $_now - $_last;
            if ($_sec <= ini_get('session.gc_maxlifetime')) {
                $this->lastOnline = "Online";
            } elseif ($_last > strtotime("-1 hour", $_now)) {
                $this->lastOnline = "больше часа";
            } elseif ($_last > strtotime("-2 hours", $_now)) {
                $this->lastOnline = "1 час";
            } elseif ($_last > strtotime("-1 day", $_now)) {
                $this->lastOnline = round($_sec/60/60) ." часов";
            } elseif ($_last > strtotime("-2 days", $_now)) {
                $this->lastOnline = "1 день";
            } elseif ($_last > strtotime("-1 week", $_now)) {
                $this->lastOnline = round($_sec/(24*60*60)) ." дней";
            } elseif ($_last > strtotime("-2 weeks", $_now)) {
                $this->lastOnline = "1 неделю";
            } elseif ($_last > strtotime("-1 month", $_now)) {
                $this->lastOnline = round($_sec/7/24/60/60) ." недель";
            } elseif ($_last > strtotime("-2 months", $_now)) {
                $this->lastOnline = "1 месяц";
            } elseif ($_last > strtotime("-3 months", $_now)) {
                $this->lastOnline = "2 месяца";
            } else {
                $this->lastOnline = "больше 3-х месяцев";
            }
        }
        return $this->lastOnline;
    }    
    
    public function isOnline()
    {
        $oDate = new Zend_Date();
        $_now = $oDate->get();
        $_last = strtotime($this->lastAccessDate);

        $_sec = $_now - $_last;
        
        if ($_sec <= ini_get('session.gc_maxlifetime')) {
            $this->lastOnline = "Online";
            return true;
        }
        return false;
    }
    
    public function updateLastAccessDate()
    {
        $query = $this->_db->quoteInto("UPDATE user SET last_access = NOW() WHERE id = ?", $this->id);
        $this->_db->query($query);
    }
    
    public function isAdmin(){
    if ($this->isAuthenticated()){
          return $this->admin;
     }
        return false;
    }

    public function isAutohouse(){
      if ($this->isAuthenticated()){
        return $this->autohouse;
      }
      return false;
    }

    public function logout()
    {
       Socnet_Session::forgetMe();
    }

    public function save()
    {
         if (!$this->id)
         {
            //Generating uniq register_code
            $gen_flag = true;
            $allowable_characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $len = strlen($allowable_characters);
            while ( $gen_flag ) {
                mt_srand((double)microtime() * 1000000);
                $code = '';
                for ( $i = 0; $i < 50; $i++ ) {
                    $code .= $allowable_characters[mt_rand(0, $len - 1)];
                }
                $attenduance = new Socnet_User('register_code', $code);
                if (!$attenduance->id) $gen_flag = false;
          }
          $this->registerCode = $code;
        }
        parent::save();
        //$id=$this->_db->lastInsertId();
        //$this->initComment($id);
    }

//    public function initComment($id)
//    {
//    	$comment = new Socnet_Comments("user");
//      $comment->initComment($id);
//    }

    public function delete()
    {
        if ( $this->id !== null ) {
           $this->status = 'deleted';
           parent::save();
        }
    }

    public function restorePassword()
    {
        $length = 10;
        $allowable_characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $len = strlen($allowable_characters);
        mt_srand((double)microtime() * 1000000);
        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $pass .= $allowable_characters[mt_rand(0, $len - 1)];
        }

        $this->pass = md5($pass);
        $this->save();

        //@todo заменить адреса через конфик или переменные
        $sender_object = new Socnet_User();
        $sender_object->email = 'support@motofriends.ru';
        $sender_object->login = 'support';
        $recipient_object = $this;
        $this->_db->query("SET NAMES koi8r");
        //  Send message
        //****************************************************
        $mail = new Socnet_Mail_Template('template_key', 'USER_REMIND_PASS');
        $mail->setEmailCharset('KOI8-R');
        $mail->setSender($sender_object);
        $mail->addRecipient($recipient_object);
        $mail->addParam('sender', $sender_object);
        $mail->addParam('recipient', $recipient_object);
        $mail->addParam('password', $pass);
        $mail->sendToEmail(true);
        $mail->send();
        $this->_db->query("SET NAMES utf8");
    }
    
    function restorePasswordOnly()
    {
        $length = 10;
        $allowable_characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $len = strlen($allowable_characters);
        mt_srand((double)microtime() * 1000000);
        $pass = '';
        for ($i = 0; $i < $length; $i++) {
            $pass .= $allowable_characters[mt_rand(0, $len - 1)];
        }
        $this->pass = md5($pass);
        $this->save();
        
        return $pass;
    }

    public function loadDefaultAvatar() {
        $select = $this->_db->select();
        $select->from('user__avatars', 'id')
               ->where('user_id = ?', $this->id)
               ->where('bydefault = ?', 1);
        $res = $this->_db->fetchOne($select);
        if ( $res ) {
           $this->avatar = new Socnet_User_Avatar($res);
        }
    }

    /**
     * validate user login data
     * @param string $login
     * @param string $password
     * @return boolean
     */
    public static function validateLogin($login, $password)
    {
        $db = Zend::registry("DB");
        $select = $db->select();
        $select->from('user', 'count(id) as count')
        ->where('login  = ?', $login)
        ->where('pass   = ?', md5($password))
        ->where('status = ?', 'active');
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }
    public static function isUserExists($key, $value, $exclude = null)
    {
        $db = Zend::registry("DB");
        if ( !in_array($key, array('id','login','nikname')) ) {
            return false;
        }
        $select = $db->select();
        $select->from('user','count(id) as count')
               ->where($key.' = ?', $value)
               ->where('status != ?', 'deleted'); // когда будет активация и управление пользователями - вернуть
        if ( $exclude !== null ) {
            $select->where($key.' NOT IN (?)', $exclude);
        }
        $res = $db->fetchOne($select);
        return (boolean) $res;
    }
    
    public function getAge()
    {
        if ( null == $this->age) {
            $this->setAge();
        }
        return $this->age;
    }

    public function setAge()
    {
        $select = $this->_db->select();
        $select->from('user', '( YEAR( CURRENT_DATE )-YEAR( birthday ) )- ( RIGHT( CURRENT_DATE, 5 ) < RIGHT( birthday, 5 ) ) AS age')
               ->where('id = ?', $this->id);
         //print $select->__toString();exit;
        $this->age = $this->_db->fetchOne($select);
        return $this;
    }
    
    public function getExperience()
    {
        if ( null == $this->experience) {
            $this->setExperience();
        }
        return $this->experience;
    }
    
    public function setExperience()
    {
        $select = $this->_db->select();
        $select->from('user', '(YEAR(CURRENT_DATE)-YEAR(experience))-(RIGHT(CURRENT_DATE,5)<RIGHT(experience,5)) AS age')
               ->where('id = ?', $this->id);
        $this->experience = $this->_db->fetchOne($select);
        return $this;
    }
    
    public function getNowTimeStamp()
    {
        $select = $this->_db->select();
        if ($this->id)
        {
            $select->from('user', 'UNIX_TIMESTAMP(CONVERT_TZ(NOW(), "UTC", timezone)) AS now_time')
                   ->where('id = ?', $this->id);
        }
        else
        {
            $select->from('DUAL', 'UNIX_TIMESTAMP(CONVERT_TZ(NOW(), "UTC", "America/New_York")) AS now_time');
        }
        $time = $this->_db->fetchOne($select);
        return $time;
    }

    public function getAvatarsListAssoc()
    {
        $select = $this->_db->select()
                       ->from('user__avatars', array('id', 'bydefault'))
                       ->where('user_id = ?', $this->id);
        $avatars = $this->_db->fetchPairs($select);

        return $avatars;
    }

     public function getAvatarsList()
    {
        $avatarsList = $this->getAvatarsListAssoc();
        $avatars = array();
        foreach($avatarsList as $key=>$value){
            $avatars[] = new Socnet_User_Avatar($key);
        }
        return $avatars;
    }

    public function saveUtility($inArray = array())
    {
        if ($inArray) {
                $this->_db->beginTransaction();
                $where = $this->_db->quoteInto('user_id = ?',$this->id);
                $sql1 = $this->_db->delete('user__userutility',$where);
                
                try {
                    foreach ($inArray as $key => $value){
                        if ($value){
                            $sql2 = $this->_db->insert('user__userutility',
                                                        array('user_id' => $this->id,
                                                        'utility_id' => $key));
                        }
                    }

                    $this->_db->commit();
                } catch (Exception $e) {
                    $this->_db->rollBack();
                    echo $e->getMessage();
                }

            }
    }

    public function getUserUtilityes()
    {
        $sql = $this->_db->quoteInto('SELECT uu.id,uu.name FROM `user__utility` uu
                                        LEFT JOIN `user__userutility` uuu ON (uu.id = uuu.utility_id)
                                      WHERE user_id =?', $this->id);
        $result = $this->_db->fetchPairs($sql);
        return $result;
    }
    
    public function getBikeId()
    {
        return $this->bikeId;   
    }
    
    // 
    public function setBikeId( $bikeId )
    {
        $this->bikeId = $bikeId;
        return $this;   
    }
    
    public function getBike()
    {
        if ( null == $this->Bike ) {
            $this->setBike();
        }   
        return $this->Bike;
    }
    
    public function setBike( $bike = null )
    {
        if ( null == $bike ) {
            $this->Bike = new Socnet_Catalog_Model_Year_Item ( $this->bikeId );
        } else {
            $this->Bike = $bike;
        }
        return $this;   
    }    
    
    public function getStatusImage()
    {
        $pic = $this->isOnline() ? 'online' : 'offline';
        return "<img src=\"/images/$pic.png\" class=\"png\" style=\"border-style: none;\" width=\"16px\" height=\"16px\">";        
    }
/**
     * @return unknown
     */
    public function getHelmetIcon () { 
    	if ( null == $this->helmetIcon ) {
    		$this->setHelmetIcon();
    	}
    	return $this->helmetIcon; 
    }

/**
     * @param unknown_type $helmetIcon
     */
    public function setHelmetIcon ( ) 
    { 
    	$helmetImgShadow = null;
    	$helmetImg = null;
    	if ( null !== $this->getBikeId() )
		{
		    // Bike
		    $bike = $this->getBike();
		    
		    if ( null == $bike->getCategory() )
		        $category = 'чоппер';
		    else 
		    	$category = $bike->getCategory()->getName();
		    	
		    switch ($category){
		        case 'чоппер':
		        case 'туристический ': 
		            $helmetImg = 'chopper_helmet';
		            break;
		        case 'спорт':
		        case 'супер-спорт' :
		        case 'спорт-турист' : 
		        case 'дорожный' : 
		        case 'нейкед' : 
		        case 'макси-скутер' : 
		            $helmetImg = 'sport_helmet';
		            break;
		        case 'кроссовый':
		        case 'эндуро':
		        case 'мотард':
		            $helmetImg = 'cross_helmet';
		            break;
		            
		        default:
		            $helmetImg = 'sport_helmet';
		    }
		} else {
		    $helmetImg = 'sport_helmet';
		}    	
    	
    	$this->helmetIcon = $helmetImg;
    	$this->helmetShadowIcon = $helmetImg. '_shadow';
    	return $this;
    }

    public function getHelmetShadowIcon () { 
    	if ( null == $this->helmetShadowIcon ) {
    		$this->setHelmetIcon();
    	}
    	return $this->helmetShadowIcon; 
    }
}
