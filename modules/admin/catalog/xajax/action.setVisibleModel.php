<?php
$objResponse = new xajaxResponse();

if ( null !== $modelId ) {
    $model = new Socnet_Catalog_Model_Item( $modelId );
    $model->setDisplay( (bool)$checked );
    $model->save();

    $objResponse->addScript('document.getElementById("display_'.$modelId.'").checked = '. $model->getDisplay() );
}

?>