<?php
    class Socnet_Board_Options extends Socnet_Data_Entity
    {
        public  $id;
        public  $name;
        public  $status = 'false';
        public  $create_date;

        function __construct($id = null)
        {
            parent::__construct('board__options_settings');

            $this->addField('id');
            $this->addField('name');
            $this->addField('status');
            $this->addField('create_date');

            if ($id) {
                parent::loadByPk($id);
            }
        }

        public function setOptionsListAssoc(){
            $sql = $this->_db->select()
                            ->from('board__options_settings', array('id', 'name', 'status'))
                            ->order('name');
            $posts = $this->_db->fetchAll($sql);
            return $posts;
        }

        public function saveFromOptions ($fields = array()){

        }
    }
    ?>