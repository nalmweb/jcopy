<?php
  class Socnet_User_Profit extends Socnet_Data_Entity
{
    public $id;
    public $groupName;
    public $name;

    function __construct($id = null)
    {
           parent::__construct('view__users_profit');

           $this->addField('id');
           $this->addField('profgroup', 'groupName');
           $this->addField('profname', 'name');

        if ( $id ) {
           $this->pkColName = 'id';
           $this->loadByPk($id);
        }
    }

   public function getProfit()
    {
        $sql = $this->_db->select()
                         ->from('view__users_profit', array('id','profgroup','profname'))
                         ->where('id=?', $this->id)
                        ;
        $profit = $this->_db->fetchRow($sql);

        return $profit;
    }

    public function getProfitsListAssoc()
    {
        $sql = $this->_db->select()
                    ->from('view__users_profit', array('id','profgroup','profname'))
                    ->order('profgroup');
        $profits = $this->_db->fetchAssoc($sql);

        return $profits;
    }

    public function getListToSelect() {
        $listArray = self::getProfitsListAssoc();

        $outArray = array();
        $group = '';
        foreach($listArray as $key => $value) {
            if ($group != $value['profgroup']) {
                $option =  $value['profgroup'];
                $group = $value['profgroup'];
            } else {
                $option =  "\t- {$value['profname']}";
            }
            $outArray[$value['id']] =  $option;
        }

        return $outArray;
    }
}
?>
