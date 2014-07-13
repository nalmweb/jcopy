<?php
/*
 * Created on 21.06.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Socnet_Board_Factory{
 	
  
    public function __construct(){
    	
    }    
    
    /**
     *   @param: $type - this is a cat_id : details, bikes, outfit
     */
    public static function getInstance($type,$id=null)
	{
		
		if($type==1 || $type==2 || $type==3)
			return new Socnet_Board_Item($type,$id);
		else
			return null;
		/*switch($type)
		{
			case 1:
				return new Socnet_Board_Item($type,$id);			
			break;
			
			case 2:
			
			break;
			
			case 3:
			
			 break;
			
			default:
				return null;
		}*/
	}
} 
?>
