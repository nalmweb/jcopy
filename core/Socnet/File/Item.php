<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Group
 * @copyright  Copyright (c) 2006
 */

/**
 * Class for File processing
 *
 */
class Socnet_File_Item
{
    /**
     * check is uploaded file is image
     * @param $fileName - Uploaded file name
     * @param $filePath - path to uploaded file
     * @param bool true/false
     */
    static function isImage($fileName, $filePath)
    {
        $valid_extension = array("jpg", "jpeg", "gif", "png");

        if (file_exists($filePath)){
            $parts = explode(".", $fileName);
            $extension = strtolower($parts[count($parts)-1]);

            if (in_array($extension, $valid_extension)){
                $sourceInfo = getimagesize($filePath);
                $format = strtolower(substr($sourceInfo["mime"], strpos($sourceInfo["mime"], '/')+1));
                if (in_array($format, $valid_extension)){
                    return array($sourceInfo[0], $sourceInfo[1]);
                }
            }
        }
        return false;
    }
    /**
     * Проверяет, существует ли файл (файлы), пришедшие для аплоада
     * @param string $nameRegexp - регуляр-соответствие имени
     * @return bool
     */
    static function filesIssetForUpload($nameRegexp = null)
    {
        $isset = false;
        if ( !isset($_FILES) || sizeof($_FILES) == 0 ) return false;
        foreach ( $_FILES as $_name => $_file ) {
            if ( $nameRegexp !== null ) {
                if ( preg_match($nameRegexp, $_name, $match) ) {
                    if ( $_file['name'] != '' && $_file['tmp_name'] != '' ) $isset = true;
                }
            } else {
                if ( $_file['name'] != '' && $_file['tmp_name'] != '' ) $isset = true;
            }
        }
        return $isset;
    }
    /**
     * Upload file
     * @param string $from - full filepath
     * @param string $to - full filepath
     * @return bool - result
     */
    static function uploadFile($from, $to)
    {
        if ( is_uploaded_file($from) ) {
            if ( @move_uploaded_file($from, $to) ) return true;
        }
        return false;
    }
    /**
     * Return expansion of file
     * @param string $filename - name or path of file
     * @return string
     */
    static function getFileExp($filename)
    {
        $filename = basename($filename);
        $exp = split("\.", $filename);
        return ( sizeof($exp) > 1 ) ? strtolower($exp[sizeof($exp) - 1]) : '';
    }
    
     /**
      *  @param: $dir - a directory where the files are located
      */
    static function getFileList($dir){
        $list = array();
    	if (is_dir($dir))
    	{
	    	 if ($dh = opendir($dir))
	    	 {
	    		while (($file = readdir($dh)) !== false)
	    		{
				   if($file == "." || $file == "..")
				   		continue;
				   $list[]=$file; 			    		  	
	    		}
	    	 }
        }
        closedir($dh);
        return $list;
    }
}