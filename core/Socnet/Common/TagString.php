<?php
/**
 * Socnet FRAMEWORK
 *
 * @copyright  Copyright (c) 2006
 */

/**
 * Class for Image processing
 *
 */
class Socnet_Common_TagString
{

    /**
     * Create string with links to tags
     *
     * @param array $tagArray       - array of tags
     * @param string $baseHref      - url for tags
     * @param string $delimeter     - delimeter to divide tags in string
     * @param int $limit            - max tags in string
     * @return string
     */

    static function makeTagString($tagArray, $baseHref, $delimeter, $limit = null)
    {
        $tagCount       = count($tagArray);
        $outputString   = "";
        if ($limit !== null) $tagCount = floor($limit);

        for ($i=0; $i < $tagCount; $i++){
            $outputString .= '<a href="'.$baseHref.$tagArray[$i]->name.'">'.$tagArray[$i]->name.'</a>'.$delimeter;
        }
        return $outputString;
    }
}