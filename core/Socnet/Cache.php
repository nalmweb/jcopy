<?php
class Socnet_Cache
{
    private static $fileCache;
    private function __construct() 
    {
    
    }
    public static function getFileCache()
    {
        if ( null === self::$fileCache ) {
            $frontendOptions = array('lifetime' => 300, 'automatic_serialization' => true);
            $backendOptions = array('cache_dir' => APP_VAR_DIR.'/cache/');
            self::$fileCache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        }
        return self::$fileCache;
    }
    
}