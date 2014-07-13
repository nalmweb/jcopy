<?php
/**
    'bikes' :	$cat_id=1; 
    'details': $cat_id=2; 
	'outfit' : $cat_id=3;
	
	mark_details_id - производитель запчасти.
	
 */
 class Socnet_Board_List extends Socnet_Abstract_List 
 {
 	private $cat_id;
 	private $m_table;
 	
 	private $user_id;
 	
 	private $type_id;
    private $model_id;
    private $kind_id;
 	private $trademark_id;
 	
 	// details
 	private $details_mark_id;
 	
 	private $aYear;
 	private $year_from; 	
 	private $year_to;
 	
 	private $aProbeg;
 	private $probeg_from;
 	private $probeg_to;
 	
 	private $aPrice;
 	private $price_from;
 	private $price_to;
 	
 	private $has_image;
 	private $bGetCount=false;
 	private $iCount;
 	private $num_items;
 	
 	private $is_active=1; // show only active listings.
 	private $is_selected; //
 	private $is_torg;
 	 	
 	public function setCatId($cat_id)
 	{
 	  $this->cat_id = $cat_id;
 	  if( $cat_id==BIKES)
 	  		$this->m_table='board__bikes';
 	  else if($cat_id==DETAILS)
 	  	    $this->m_table='board__details';		
 	  else if($cat_id==OUTFIT)
 	  	    $this->m_table='board__outfit'; 	    
 	}
 	
 	public function getCatId(){
 		return $this->cat_id;
 	}
 	
 	/**
 	 *   This is That man! now!
 	 */
    public function getList()
    {
        $query = $this->_db->select(); //
        
        if ( $this->isAsAssoc() )
        {
            $fields = array();
            $fields[] = ( $this->getAssocKey() === null ) ? 'id' : $this->getAssocKey();
            $query->from( $this->m_table,$fields );  
        }
        else
        {
            $query->from( $this->m_table, 'id' );
        }

        if ( null !== $this->getTypeId() ) {
            $query->where( 'type_id = ?', $this->type_id );
        }
        
        if ( null !== $this->getTrademarkId() ) {
            $query->where( 'mark_id = ?', $this->trademark_id );
            
            //details
            //add condition for all marks
            if($this->getCatId()==2)
            {            
              $query->orWhere('mark_id = ?', ALL_DETAILS_MARKS);
              // For all models too;
              // add condition for all models of given mark
              if(null==$this->getModelId()){
              	$query->orWhere('model_id = ?', ALL_DETAILS_MODELS);
              }
            }
        }
                
        if ( null !== $this->getDetailsTrademarkId() )
        {
            $query->where( 'mark_details_id = ?', $this->details_mark_id );
        }
        
        if ( null !== $this->getModelId() ) {
            $query->where( 'model_id = ?', $this->model_id );
            
            if($this->getCatId==DETAILS)
            {
             $query->orWhere('model_id = ?', ALL_DETAILS_MODELS);
            }
        }
        
        if ( null !== $this->getIsActive() ) {
        
        	//echo "act=". $this->getIsActive();
            $query->where( 'is_active = ?', $this->is_active );
        }
        
        if ( null !== $this->getUserId() ) {
            $query->where( 'user_id = ?', $this->getUserId() );
        }
        
        if ( null !== $this->getKindId() ) {
            $query->where( 'kind_id = ?', $this->kind_id );
        }
        // SET PRICES
        if(!empty($this->aPrice['from']) || !empty( $this->aPrice['to']))
        {
	    	if(!empty($this->aPrice['from']) && !empty( $this->aPrice['to'] ) )
	    	{
	    		$sql = "price_rur BETWEEN  ".$this->aPrice['from']." AND ".$this->aPrice['to'];
	    		$query->where($sql);
	    		// $query->where("AND ?",$this->aPrice['to']); 
	    	}
	    	else if (empty($this->aPrice['from']) && !empty($this->aPrice['to']))
	    	{
	    		$query->where("price_rur <=? ",$this->aPrice['to']);	
	    	}
	    	else if (!empty($this->aPrice['from']) && empty($this->aPrice['to'])){
	    		$query->where("price_rur >=? ",$this->aPrice['from']);
	    	}
        }
    	// SET PROBEG
    	if( !empty ($this->aProbeg['from']) || !empty($this->aProbeg['to']))
    	{
			if(!empty($this->aProbeg['from']) && !empty( $this->aProbeg['to'] ) )
	    	{
	    		$sql = "probeg BETWEEN  ".$this->aProbeg['from']." AND ".$this->aProbeg['to'];
	    		$query->where($sql);
	    		// $query->where("AND ?",$this->aPrice['to']); 
	    	}
	    	else if (empty($this->aProbeg['from']) && !empty($this->aProbeg['to']))
	    	{
	    		$query->where("probeg <=? ",$this->aProbeg['to']);	
	    	}
	    	else if (!empty($this->aProbeg['from']) && empty($this->aProbeg['to'])){
	    		$query->where("probeg >=? ",$this->aProbeg['from']);
	    	}
    	}
    	// SET YEAR
    	if( !empty ($this->aYear['from']) || !empty($this->aYear['from']))
    	{
			if(!empty($this->aYear['from']) && !empty( $this->aYear['to'] ) )
	    	{
	    		$sql = "year BETWEEN  ".$this->aYear['from']." AND ".$this->aYear['to'];
	    		$query->where($sql);
	    		// $query->where("AND ?",$this->aPrice['to']); 
	    	}
	    	else if (empty($this->aYear['from']) && !empty($this->aYear['to']))
	    	{
	    		$query->where("year <=? ",$this->aYear['to']);	
	    	}
	    	else if (!empty($this->aYear['from']) && empty($this->aYear['to'])){
	    		$query->where("year >=? ",$this->aYear['from']);
	    	}
    	}
    	
		if($this->bGetCount)
        {
           $this->num_items = $this->countItems( $query );
           $query->reset("columns");
		   $query->reset("from");
           $query->from($this->m_table, 'id');
        }        
        //   
        if ( $this->getCurrentPage() !== null && $this->getListSize() !== null )
        {
            $query->limitPage($this->getCurrentPage(), $this->getListSize());
        }
        
        if ( $this->getOrder() !== null )
        {
            $query->order($this->getOrder());
        }
        
        $items = array();
        if ( $this->isAsAssoc() )
        {
            $items = $this->_db->fetchPairs($query);
        }
        else
        {
           // echo "sql=".$query->___toString();
           //dump($query);
           $items = $this->_db->fetchAll($query);
           //dump($items);
           foreach ( $items as &$item ) $item = new Socnet_Board_Item($this->cat_id,$item);
           // dump($items);
        }
        return $items;       
    }

	/**
		$flag - specifies, whether it is necessary to set values.
	*/
    public function shouldCount($flag){
    	$this->bGetCount = $flag;
    }
    
    public function setUserId($user_id){
    	$this->user_id=$user_id;
    }
    
    public function setTypeId($id){
    	$this->type_id =$id;
    }
    
    public function setKindId($id){
    	$this->kind_id=$id;
    }
    
    public function setTrademarkId($id){
    	$this->trademark_id =$id;
    }
    
    public function setDetailsTrademarkId($id){
    	$this->details_mark_id=$id;
    }
    
    public function setModelId($id){
    	$this->model_id=$id;
    }
    
    public function setHasImage($flag){
    	$this->has_image=$flag;
    }
    
    /**
     *  @param: $aYear ::=>array ('from','to'); 
     */ 
    public function setYearArray($aYear){
    	$this->aYear=$aYear;
    }
    
    /**
     *  @param: $aPrice ::=>array ('from','to'); 
     */
    public function setPriceArray($aPrice){
    	$this->aPrice=$aPrice;
    }
    
    /**
     *   @param: $aProbeg ::=>array ('from','to');
     */
    public function setProbegArray($aProbeg){
    	$this->aProbeg=$aProbeg;
    }
    
    //  
	public function getUserId(){
		return $this->user_id;
	}
	
    public function getTypeId(){
    	if(!empty($this->type_id))
    		return $this->type_id;
    	return null;	
    }
    public function getTrademarkId(){
    	if(!empty($this->trademark_id))
    		return $this->trademark_id;
    	return null;	
    }
    
    public function getDetailsTrademarkId(){    	
    	if(!empty($this->details_mark_id))
    		return $this->details_mark_id;
    	return null;
    }
    
    // :: This is thaT ::
    public function getHasImage($flag){
    	if(!empty($this->has_image))
    		return $this->has_image;
    	return null;
    }
    //
    public function getModelId()
    {
    	if(!empty($this->model_id))
    		return $this->model_id;
    	return null;	
    }
    public function getKindId(){
       	if(!empty($this->kind_id))
    		return $this->kind_id;
    	return null;
    }
    public function getYearArray(){
    	return $this->aYear;
    }
    public function getPriceArray(){
    	return  $this->aPrice;
    }
    public function getProbegArray(){
      return $this->aProbeg;	
    }
    
    public function getIsActive(){
       	return $this->is_active;
    }
    
    public function getIsSelected(){
    	return $this->is_selected;
    }
    
    public function getIsTorg(){
    	return $this->isTorg;
    }
    
    public function setIsActive($v){
    	$this->is_active=$v;
    }
    public function setIsTorg($v){
    	$this->is_torg=$v;
    }
    public function setIsSelected($v){
    	$this->is_selected=$v;
    }
    /**
     *  ads: total,new,today
     */ 
    public function getCount()
    {
   	   $query=$this->_db->select()->from($this->m_table,"COUNT(*)");
   	   return $this->_db->fetchOne($query);
    }
    /**
		$query->reset("columns") ->  resets [columns]=''
	*/
    private function countItems($query)
    {
       $query->reset("columns");
       $query->reset("from");
       $query->from($this->m_table, "COUNT(*)");
   	   $count = $this->_db->fetchOne($query);
   	   return $count; 
    }
    // 
    public function getNumItems()
    {
    	if (!empty($this->num_items))
    		  return $this->num_items;
    	else
    		  return 0;
    }
 }
?>
