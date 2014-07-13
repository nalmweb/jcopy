<?php
/*
 * Created on 18.03.2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Socnet_Image_PhotoConfig
 {
   public $path;
   public $width; 
   public $height;
 	
   public function setPath($path){ $this->path = $path;}
   public function setWidth($x)  {$this->widht=$x; 	   }
   public function setHeight($y) {$this->height=$y;    }
    	
   public function getPath()   { return $this->path;   }
   public function getWidth()  { return $this->widht;  }
   public function getHeight() { return $this->height; }
   
 }
?>
