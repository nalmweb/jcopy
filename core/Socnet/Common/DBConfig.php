<?php

    class Socnet_Common_DBConfig {

        private $_db;

        public function __construct() {
            $this->_db = Zend_Registry::get("DB");
        }

        public function get($key){
            $val = $this->_db->fetchRow("SELECT `val` FROM `socnet_config` WHERE `key`='".$key."'");
            return $val['val'];
        }

        public function set($key, $val){
            if ($this->_db->query("UPDATE `socnet_config` SET `val`='".$val."' WHERE `key`='".$key."'")) return true;
            else return false;
        }

    }
?>
