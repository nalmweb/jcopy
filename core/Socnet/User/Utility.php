<?php
    class Socnet_User_Utility extends Socnet_Data_Entity
    {
        public  $id;
        public  $name;

        function __construct($id = null)
        {
            parent::__construct('user__utility');

            $this->addField('id');
            $this->addField('name');

            if ($id) {
                parent::loadByPk($id);
            }
        }

        public function setUtilityListAssoc()
        {
            $sql = $this->_db->select()
                            ->from('user__utility', array('id', 'name'))
                            //->where('city_id=?', $this->id)
                            ->order('name');
            $posts = $this->_db->fetchPairs($sql);
            return $posts;
        }

        public function saveFromUser($fields = array()){
	          if ($fields) {
                $this->_db->beginTransaction();
                $where = $this->_db->quoteInto('user_id = ?',$this->_page->_user->id);
                $sql1 = $this->_db->delete('user__userutility',$where);

                try {
                    foreach ($fields as $key => $value){
                        if ($value){
                            $sql2 = $this->_db->insert('user__userutility',
                                                        array('user_id' => $this->_page->_user->id,
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
    }
    ?>