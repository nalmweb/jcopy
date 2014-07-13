<?php
    /* Note: This thumbnail creation script requires the GD PHP Extension.  
        If GD is not installed correctly PHP does not render this page correctly
        and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
     */

    ini_set('memory_limit', '36M');
    // Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
    $objResponse = new xajaxResponse();
    
    //  Check the upload
    if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "invalid upload";
        exit(0);
    }
    
    // Get the image and create a thumbnail
    $img = @imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
    
    if (!$img) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "could not create image handle";
        exit(0);
    }
    
    $fileName =  md5($_FILES["Filedata"]["name"] + rand()*100000);
    
    
    $width = imageSX($img);
    $height = imageSY($img);
    
    if (!$width || !$height) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Invalid width or height";
        exit(0);
    }
    
    if ( $width > $height ) {
        // Build the original
        $target_width = $width >= 500 ? 500 : $width;
        $offsetx = $target_width/ $width;
        $target_height = $height*$offsetx;
        $target_ratio = floor($target_width / $target_height);
    
        $new_width = $width >= 500 ? 500 : $width;
        $offsetx = $new_width/ $width;
        $new_height = floor($height*$offsetx);
    } else {
        // Build the original
        $target_height = $height >= 500 ? 500 : $height;
        $offsetx = $target_height/ $height;
        $target_width = $width*$offsetx;
        $target_ratio = floor($target_height / $target_width);
    
        $new_height = $height >= 500 ? 500 : $height;
        $offsetx = $new_height / $height;
        $new_width = floor($width *$offsetx);
    }
    
    $new_img = ImageCreateTrueColor($new_width, $new_height);
    if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) { // Fill the image black
        header("HTTP/1.1 500 Internal Server Error");
        echo "Could not fill new image";
        exit(0);
    }

    if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width), ($target_height-$new_height), 0, 0, $new_width, $new_height, $width, $height)) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Could not resize image";
        exit(0);
    }
    
    $new_img = Socnet_Photo::UnsharpMaskImage( $new_img );
    @imagejpeg( $new_img, CATALOG_PHOTOS. $fileName. "_big.jpg", 90);
    
    // Build the thumbnail
    if ( $width > $height ) {
        // Build the original
        $target_width = $width >= 128 ? 128 : $width;
        $offsetx = $target_width/ $width;
        $target_height = $height*$offsetx;
        $target_ratio = floor($target_width / $target_height);
    
        $new_width = $width >= 128 ? 128 : $width;
        $offsetx = $new_width/ $width;
        $new_height = floor($height*$offsetx);
    } else {
        // Build the original
        $target_height = $height >= 128 ? 128: $height;
        $offsetx = $target_height/ $height;
        $target_width = $width*$offsetx;
        $target_ratio = floor($target_height / $target_width);
    
        $new_height = $height >= 128? 128 : $height;
        $offsetx = $new_height / $height;
        $new_width = floor($width *$offsetx);
    }
     
    $new_img = ImageCreateTrueColor($new_width, $new_height);
    if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) { // Fill the image black
        header("HTTP/1.1 500 Internal Server Error");
        echo "Could not fill new image";
        exit(0);
    }

    if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width), ($target_height-$new_height), 0, 0, $new_width, $new_height, $width, $height)) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Could not resize image";
        exit(0);
    }
    
    if (!isset($_SESSION["file_info"])) {
        $_SESSION["file_info"] = array();
    }
    $new_img = Socnet_Photo::UnsharpMaskImage( $new_img );
    @imagejpeg( $new_img, CATALOG_PHOTOS. $fileName. "_thumbnail.jpg", 90);
    
    if ( isset( $this->params['modelId'] ) && $this->params['modelId'] ) {
        $photo = new Socnet_Catalog_Metadata_Item();
        $photo->setIdTypeMetadata( 2 );
        $photo->setFileName( $fileName );
        $photo->setOriginalFileName( $_FILES["Filedata"]["name"] );
        $photo->save();
        
        $model = new Socnet_Catalog_Model_Year_Property_Item();
        $model->setIdProperty( 35 );    
        $model->setValue( $photo->getId() );
        $model->setIdModelGod( $this->params['modelId'] );
        $model->save();
    }

    // Use a output buffering to load the image into a variable
    ob_start();
    imagejpeg($new_img);
    $imagevariable = ob_get_contents();
    ob_end_clean();

    $_SESSION["file_info"][$fileName] = $imagevariable;
    //dump($_SESSION);
    ini_set('memory_limit', '16M');
    print $fileName;  // Return the file id to the script
    exit;
?>      