<?php
    // This script accepts an ID and looks in the user's session for stored thumbnail data.
    // It then streams the data to the browser as an image
    
    // Work around the Flash Player Cookie Bug
    $objResponse = new xajaxResponse();    
    $image_id = isset($_GET["id"]) ? $_GET["id"] : false;

    if ($image_id === false) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "No ID";
        exit(0);
    }

    if (!is_array($_SESSION["file_info"]) || !isset($_SESSION["file_info"][$image_id])) {
        header("HTTP/1.1 404 Not found");
        exit(0);
    }

    //header("Content-type: image/jpeg") ;
    //header("Content-Length: ".strlen($_SESSION["file_info"][$image_id]));
    ///print 111;
    print $_SESSION["file_info"][$image_id];
    //print "<img src=\"./images/catalog/pic/.{$_SESSION["file_info"][$image_id]}_thumbnail.jpg\">";
    
    exit(0);
?>