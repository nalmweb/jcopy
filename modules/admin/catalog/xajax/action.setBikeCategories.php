<?php
/*
 * Created on 21.02.2008
 
    This action is used to set bike category to all model-year bikes.
    
    
    what we have:
    
     catalog__data_list_property as T1
    		 тут список свойств: эндуро, кроссовый, ... ,    		   		 
     
     берем id_model
     
      получаем список всех моделей в catalog__model_god
       for inst:  
      		1381, 2000
      		1382, 2001
      		
      В catalog__model_property:
      	   insert id_property=1, id_model_god, value=null,value_list=id from T1
 */
   $objResponse = new xajaxResponse();
   // $modelId=6;
   
   $modelYear = new Socnet_Catalog_Model_Year_List();   
   $modelYear->setIdModel($modelId);
   $modelYear->returnAsAssoc(false);
   
   // получили список модель-год.
   $modelYearList = $modelYear->getList();
   // теперь для каждого id из этого списка:
   /**
       В catalog__model_property:
      	   insert id_property=1, id_model_god, value=null,value_list=id from T1
   */

 $ids = '';
   
   foreach ($modelYearList as $item)
   {
   	   $this->_db->delete("catalog__model_property","id_property=1 and id_model_god =".$item->getId());
   	   /* $where = $this->_db->quoteInto( 'id_model_god = ?', $item->getId() );
        $sql = $this->_db->delete('catalog__model_property',$where);*/
     // $sql = " insert into catalog__model_property values (0,1,".$item->getId().",'',".$bike_category_id.",0);";
   	   
   	   $this->_db->insert( 'catalog__model_property',
                                   array(
                                         'id_property' => 1,
                                         'id_model_god' => $item->getId(),
                                         'value' => '',
                                         'value_list' =>$bike_category_id,
                                         'flag_disc'=>0)
                                 );
	  //$ids .= $sql;
	  //$ids .= "\n";
   }
   $objResponse->addAlert("Данные сохранены");
   //$objResponse->addAlert($ids);
   return $objResponse;
   
   //$sql = " insert into catalog__model_property values(0,1,$modelId,)"
   // id 	id_property 	id_model_god 	value 	value_list 	flag_disc 
   /*$propItem = new Socnet_Catalog_Model_Property_Item();
   
   $propItem->setIdProperty(1);
   $propItem->setIdModelGod($item->getIdModel());
   $propItem->setValuesList($bike_category_id);
   $propItem->save();
  */
?>
