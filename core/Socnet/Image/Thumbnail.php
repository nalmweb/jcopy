<?php
/**
 * Socnet FRAMEWORK
 *
 * @package    Socnet_Group
 * @copyright  Copyright (c) 2006
 */

/**
 * Class for Image processing
 *
 */
class Socnet_Image_Thumbnail
{
    /**
     * @param string $sourcePath - source image path
     *
     * @param string $thumbnailPath - thumbnail path
     *
     * @param integer $targetWidth - thumbnail width
     *
     * @param integer $targetHeight - thumbnail height
     *
     * @param boolean $addBorder - draw border and leave initial size of image, if thumbnail size bigger than it.
     *
     * @param string $borderColor - string representation of RGB color for border. format R,G,B
     *
     * @param string $result - contain result of convertion. ok - if all right, or error message;
     *
     */

    static function makeThumbnail($sourcePath, $thumbnailPath, $targetWidth = 0, $targetHeight = 0, $addBorder = false, $borderColor = "255,255,255")
    {
        $targetWidth     = floor($targetWidth);
        $targetHeight    = floor($targetHeight);
        $addBorder       = (bool)$addBorder;
        $borderColor     = $borderColor;
        $result          = "ok";
        /*Get image size */
        $sourceSize = getimagesize($sourcePath);
        if (false === $sourceSize) {
            $result = "cant get image size";
            return $result;
        }

        //Check image type using MIME info
        $format = strtolower(substr($sourceSize['mime'], strpos($sourceSize['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;

        if (!function_exists($icfunc)) {
            $result = "function ($icfunc) isnt exist";
            return $result;
        }

        $sourcePic = @$icfunc($sourcePath);
        //print $sourcePic." <br>";
        if ($sourcePic == "") {
            $result = "cant apply $icfunc function";
            return $result;
        }

        $width = $targetWidth;  //thumbnail width
        $height = $targetHeight;//thumbnail height
        $bwidth = $sourceSize[0]; 	    //initial image width
        $bheight = $sourceSize[1];    //initial image height

        //add border to image
        if ($addBorder) {
            $rgb = explode(",", $borderColor);

            if ($bwidth < $width){//add border
                $temp = imagecreatetruecolor($width, $bheight);
                $white = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
                imagefilledrectangle($temp, 0,0,$width, $bheight, $white);
                imagecopyresized($temp, $sourcePic, ($width - $bwidth)/2, 0, 0, 0, $bwidth, $bheight, $bwidth, $bheight);
                $bwidth = $width;
                $sourcePic = $temp;
            }

            if ($bheight < $height){//add border
                $temp = imagecreatetruecolor($bwidth, $height);
                $white = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
                imagefilledrectangle($temp, 0,0, $bwidth, $height, $white);
                imagecopyresized($temp, $sourcePic, 0, ($height - $bheight)/2, 0, 0, $bwidth, $bheight, $bwidth, $bheight);
                $bheight = $height;
                $sourcePic = $temp;
            }
        }

        //resize
        $scaleX = $bwidth / $width;
        $scaleY = $bheight / $height;

        if ($scaleX > $scaleY){
            $newWidth = $bwidth / $scaleY;
            $newHeight = $height;
        } else {
            $newWidth = $width;
            $newHeight = $bheight / $scaleX;
        }

        $thumbnailPic = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresized($thumbnailPic,$sourcePic, 0, 0, 0, 0, $newWidth, $newHeight, $bwidth, $bheight);

        $temp = imagecreatetruecolor($width, $height);
        if ($newWidth > $width){
            imagecopyresampled($temp, $thumbnailPic, 0, 0, ($newWidth-$width)/2, 0, $width, $height, $width, $newHeight);
        } else {
            imagecopyresampled($temp, $thumbnailPic, 0, 0, 0, ($newHeight-$height)/2, $width, $height, $newWidth, $height);
        }

        imagejpeg($temp, $thumbnailPath, 100);

        if (!file_exists($thumbnailPath)){
            $result = "cant create file";
            return $result;
        }

        imagedestroy($temp);
        imagedestroy($thumbnailPic);
        return $result;
    }
}