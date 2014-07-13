<?
/*
* Class: simpleRSS
* Purpose: to build RSS (V0.91+) channel files from provided textual inputs
* Author: Alexey Kulikov - alex@pvl.at, alex@inses.biz
* Further Notes: 
* 	1) RSS 0.92 specs are to be found here - http://backend.userland.com/rss092, http://backend.userland.com/rss
* 		 Note: you can enforse RSS2.0 by adding additional elements
* 	2) All date-times in RSS conform to the Date and Time Specification of RFC 822.
* 
* Example Usage:
* <code>
* 	$myRSS = new simpleRSS(	"Alex Says",
* 							"http://www.pvl.at",
* 							"Fall on your knees and pray the big lord",
* 							 array("ttl"=>60,"lastBuildDate"=>"Tue, 25 Mar 2003 13:13:31 GMT"));
* 
* 	$myRSS->addItem("Hello","http://www.pvl.at","Hell is here");
* 	$myRSS->addItem("Goodbye","http://www.pvl.at","Heaven is here");
* 	$myRSS->create("myFeed.xml");
* </code>
**/
class Socnet_RSS
{
		//required channel data
		public $version = "2.0";	//RSS Version for output
		public $title;				//title of the channel
		public $link;				//link to the channel
		public $description;		//description of the channel
		public $channel_image;		//image for the channel
		
		private $atom ; // for validness of and RSS: <atom:link href="URL" rel="self" type="application/rss+xml" />  
		//optional Channel Data
		public $optional = array();
		//items
		//@access private
		public $items = array();
		
		/**
		 * simpleRSS::simpleRSS() - constructor
		 * 
		 * @param $title		(string)
		 * @param $link			(string)
		 * @param $description	(string)
		 * @param $optional 	(array)
		 * @return void
		 * @access public
		 */
		function __construct($title,$link,$description,$optional="",$url=""){
			$this->title = $title;
			$this->link = $link;
			$this->description = $description;
			
			if(is_array($optional)){
				$this->optional = $optional;
			}
			//flush data
			$this->items = array();
			//$this->atom='<atom:link href="'.$url.'" rel="self" type="application/rss+xml" />';
		}
		
		/**
		 * Enter description here...
		 *
		 * @param unknown_type $image_url
		 * @param unknown_type $image_title
		 * @param unknown_type $image_link
		 */
		function setChannelImage($image_url,$image_title,$image_link)
		{
		   $this->channel_image = array('url' =>$image_url,'title'=>$image_title, 'link'=>$image_link);
		}
		/**
		 * simpleRSS::addItem() - adds an Item to end of the feeder
		 * 
		 * @param $title				(string)
		 * @param $link					(string)
		 * @param $description			(string)
		 * @param $optional				(array)
		 * @return (void)
		 * @access public
		 */
		function addItem($title,$link,$description,$optional=""){
			$item = array(
							"title"			=> 	$title,
							"link"			=>	$link,
							"description"	=>	$description
						);
			
			// RSS2.0 upgrade if needed						
			if(is_array($optional)){
				$item = array_merge($item,$optional);
			}
			
			$this->items[] = $item;
		}
		
		function addItemCDATA($title,$link,$description,$optional="")
		{
		    $item = array(  "title"			=> 	$title,
							"link"			=>	$link,
							"description"	=>	"<![CDATA[$description]]>",
						 );
			
			// RSS2.0 upgrade if needed						
			if(is_array($optional)){
				$item = array_merge($item,$optional);
			}		
			$this->items[] = $item;
		}
		
		
		function addItemWithImage($title,$link,$description,$image_path, $optional=""){
			$item = array(
							"title"			=> 	$title,
							"link"			=>	$link,
							"description"	=>	$description,
							"image"    =>  $image_path 
						);
			
			// RSS2.0 upgrade if needed						
			if(is_array($optional)){
				$item = array_merge($item,$optional);
			}
			
			$this->items[] = $item;
		}	
		
		/**
		 * simpleRSS::create() - creates an RSS XML file at the specified location
		 * 
		 * @param $fileName	(string)
		 * @return (bool)
		 * @access public
		 */
		function create($fileName,$path=null,$charset)		
		{
			if(empty($charset)) $charset='utf-8';
		    //echo "c =".$charset;		    
		    
		    if(!empty($this->channel_image))
		    {
			   $channel = array(
								"title"			=>	strip_tags($this->title),
								"link"			=>	$this->link,
								"description"	=>	strip_tags($this->description),
								"image"			=>  $this->channel_image								
							);
		    }
		    else 
		    {
		      $channel = array(
								"title"			=>	strip_tags($this->title),
								"link"			=>	$this->link,
								"description"	=>	strip_tags($this->description)								
							);
		    }
		    
			if(is_array($this->optional)){
				$channel = array_merge($channel, $this->optional);
			}
			//prepare output
			$out = "<?xml version=\"1.0\" encoding=\"".$charset."\"?>\n<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n<channel>\n" . 
					$this->_parse($channel) . 
					$this->_parse($this->items) .
					"\n</channel>" .
					"\n</rss>";
					
			// create RSS feed file
			$new_file = fopen($path.$fileName, "w");
			
			if($new_file)
			{
				fputs($new_file, $out);
				fclose($new_file);
				//rename($path.$tempFile,$path.$fileName);
				@chmod($path.$fileName,0777);
				return true;
			}else{
				return false;
			}
		}
		
		
		/**
		 * simpleRSS::getItemCount() - return number of items in object
		 * 
		 * @return (int)
		 * @access public
		 */
		function getItemCount(){
			return count($this->items);
		}
		
		
		/**
		 * simpleRSS::getItems() - return the items of the feeder
		 * 
		 * @return (array)
		 * @access public
		 */
		function getItems(){
			return $this->items;
		}
		
		########## end of public access ##########
		
		/**
		 * simpleRSS::_parse() - recursive function to create XML from associative arrays
		 * 
		 * @param $toParse
		 * @return (string)
		 * @access private
		 */
		function _parse($toParse)
		{
		    $out ='';
		    
			while(list($key,$val) = each($toParse)){
				//fix integer keys
				if(is_int($key)){
					$key = "item";
				}
				
				//check if this is an enclosure
				if($key == 'enclosure'){
					$out .= "<enclosure url=\"" . $val['url'] . "\" type=\"" . $val['type'] . "\" length=\"" . $val['length'] . "\" />";
					continue; // go to next element
				}else{
					//open tag
					$out .= "<" . $key . ">";
				}
				//check for subtags
				//echo "key = $key<br>";
				
				if(is_array($val)){	//yes
					$out .= $this->_parse($val);
				}
				else
				{	//no
					if($key != "title" && $key!="description" && $key!='image')
					{
						$out .= str_replace("&amp;","&",htmlspecialchars($val));
						//$out .= $val;
					}
					else
					{
					    if($key!="description")
						    $out .= htmlspecialchars($val);
						else
						    $out .=$val;
					}
					//$out .= htmlentities($val);
				}
				
				//close tag
				$out .= "</" . $key . ">\n";
			}
			return $out; 
		}
		
	function socnet_addItemWithImage($title,$link,$description,$image_path, $optional="")
	{
		    $item = array(
							"title"			=> 	$title,
							"link"			=>	$link,
							"description"	=>	"<![CDATA[<img src=\"$image_path\">".$description."]]>",
							/*"image"         => */
						);
			// RSS2.0 upgrade if needed
			if(is_array($optional)){
				$item = array_merge($item,$optional);
			}
			$this->items[] = $item;
			// dump($this->items);
		}
	}
?>