<?php
    class Socnet_Board_Price extends Socnet_Data_Entity
    {
        public  $id;
        public  $name;
        public  $status = 'false';
        public  $create_date;

        function __construct($id = null)
        {
            parent::__construct('board__price_settings');

            $this->addField('id');
            $this->addField('name');
            $this->addField('status');
            $this->addField('create_date');

            if ($id) {
                parent::loadByPk($id);
            }
        }

        public function setPriceListAssoc(){
            $sql = $this->_db->select()
                            ->from('board__price_settings', array('id', 'name', 'status'))
                            ->order('name');
            $posts = $this->_db->fetchAll($sql);
            return $posts;
        }

        public function saveFromPrice ($fields = array()){

        }
    }
    ?>