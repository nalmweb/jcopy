<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Mail
 * @copyright  Copyright (c) 2006
 */
class Socnet_Mail_Templates extends Socnet_Data_Entity
{
    /**
     * Constructor.
     *
    */
   public function __construct($id = null)
    {
        $this->_db = Zend::registry("DB");
    }

    /**
     * Returns all Mail Templates list
     *
     */
    public function getAllTemplatesList()
    {
        $select = $this ->_db->select()
        ->from('mail__templates', 'id')
        ->order('filename');

        $templates = $this->_db->fetchCol($select);

        foreach ($templates as &$template) {
            $template = new Socnet_Mail_Template($template);
        }
        return $templates;
    }

    /**
     * Returns all Mail Messages list
     *
     */
    public function getAllMessagesList()
    {
        $select = $this ->_db->select()
        ->from('mailtemplates__messages', 'id')
        ->order('id');

        $messages = $this->_db->fetchCol($select);

        foreach ($messages as &$message) {
            $message = new Socnet_Mail_Message($message);
        }
        return $messages;
    }
}
