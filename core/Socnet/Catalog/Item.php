<?php
class Socnet_Catalog_Item extends Socnet_Data_Entity
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function getTrademarkFromUrl( $trademark )
    {
    	$trademark = str_replace("_", " ", $trademark);
        $query = $this->_db->select();
    	$query->from('catalog__trademark', 'id');
    	$query->where('LOWER(name) = ?', $trademark);
    	
    	$trademarkId = $this->_db->fetchOne($query);
    	
    	return $trademarkId;
    }
        
    public function getModelFromUrl( $trademarkId, $model )
    {
        $model = str_replace( "_", " ", $model );
        
        $query = $this->_db->select();
        $query->from('catalog__model', 'id');
        $query->where('id_trademark = ?', $trademarkId);
        $query->where('LOWER(name) = ?', $model);
        
        $modelId = $this->_db->fetchOne($query);
        
        return $modelId;
    }
    
    public function getYearFromUrl( $modelId, $year )
    {
        $year = intval( $year );
        
        $query = $this->_db->select();
        $query->from('catalog__model_god', 'id');
        $query->where('id_model = ?', $modelId);
        $query->where('god = ?', $year);
        
        $modelId = $this->_db->fetchOne($query);
        
        return $modelId;
    }
}
?>
