<?php
/***
 * Class <code>Url</code> simplifies working with (complicated) URLs.
 * <p>
 *   Normally, creating URLs can be tough, for example because a parameter that
 *   is added already exists, resulting in two parameters with the same name.
 *   Or some parameters may always need to be passed, while others should be
 *   removed from an existing list of parameters. Class <code>Url</code> makes
 *   it easy to do these kind of things.
 * </p>
 ***/
class Socnet_URL
{
    // DATA MEMBERS

    /***
     * The base_name of the url, e.g. <code>http://www.sunlight.tmfweb.nl/</code>
     * or <code>page.php</code>.
     * @type string
     ***/
    public $base_name;

    /***
     * The array of URL parameters
     * @type array
     ***/
    public $parameters;

    /***
     * The internal URL represtation (cache)
     * @type string
     ***/
    public $representation;

     /***
     * Internal flag to check if the cache is valid
     * @type bool
     ***/
    public $valid;

    // CREATORS

    /***
     * Construct a new Url object.
     * @param $url the optional URL (a string) to base the Url on
     * @param $parameters the optional URL (a string) with parameters only
     ***/
    function Socnet_URL ($url = '', $parameters = '')
    {
    	if ( $url )
        	$this->setUrl($url, $parameters);
        else
			$this->fromCurrent();
    }

    // MANIPULATORS

    /***
     * Parse parameters in a <code>key1=value1&key2=value2&...</code> string
     * @param $parameters the URL-encoded string with the parameters
     * @returns void
     * @private
     ***/
    function parseParams($parameters)
    {
        $list = explode('&', $parameters);
        $size = count($list);
        for ($i = 0; $i < $size; $i++)
        {
            $pair = explode('=', $list[$i]);
            if (count($pair) == 2)
            {
                $this->parameters[$pair[0]] = urldecode($pair[1]);
            }
        }
        $this->valid = false;
    }

    /***
     * Set the Url to a new value
     * @param $url the URL (a string) to base this Url on
     * @param $parameters the optional string of parameters (URL-encoded)
     * @returns void
     ***/
    function setUrl($url, $parameters = '')
    {
	    //echo " <br> seturl:<br>";
	    //dump($parameters);
	    //dump($url);
	    
        // Reset the current URL
        $this->parameters = array();
        $this->valid = false;
        // Create the new URL
        $parts = explode('?', $url);
        //echo "<br> parts:";
        //dump($parts);
        
        $this->base_name = $parts[0];
        //echo "base=".$this->base_name; 
        // if 2 parts -> 
        if(count($parts) == 2)
        {
            $this->parseParams($parts[1]);
        }
        $this->parseParams($parameters);
    }

    /***
     * Set the Url to the URL of the current page;
     * @returns void
     ***/
    function fromCurrent() {
		$url   = '';
		$param = '';

    	if (array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
        	list($protocol, $version) = explode('/', strToLower($_SERVER['SERVER_PROTOCOL']), 2);
            if (array_key_exists('SERVER_PORT', $_SERVER) && $_SERVER['SERVER_PORT'] == 443) $protocol = 'https';
            	$url .= $protocol .'://';
        }

	    if (array_key_exists('SERVER_NAME',  $_SERVER)) $url .= $_SERVER['SERVER_NAME'];
        if (array_key_exists('SERVER_PORT',  $_SERVER)) $url .= ':'. $_SERVER['SERVER_PORT'];
        if (array_key_exists('SCRIPT_NAME',  $_SERVER)) $url .= $_SERVER['SCRIPT_NAME'];
        if (array_key_exists('PATH_INFO',    $_SERVER)) $url .= $_SERVER['PATH_INFO'];
        if (array_key_exists('QUERY_STRING', $_SERVER)) $param = $_SERVER['QUERY_STRING'];
        
		// dump($param);
        $this->setUrl($url,$param);
    }

    /***
     * Set the base_name for the Url
     * @param $base_name a string representing the new base_name for the Url
     * @returns void
     ***/
    function setBasename($base_name)
    {
        $this->base_name = $base_name;
        //  remove last slash
        $this->valid    = false;
    }

    /***
     * Update the value of a parameter
     * @param $parameter the name of the parameter to update
     * @param $value the new value of the parameter, or false if the parameter
     * should be deleted
     * @returns void
     ***/
    function setParam($parameter, $value = false)
    {
        if ($value === false)
        {
            unset($this->parameters[$parameter]);
           // $this->parameter[$parameter]
        }
        else
        {
            $this->parameters[$parameter] = $value;
        }
        $this->valid = false;
    }
    
    /**
     *   
     */
    function getCurrentUrl()
    {
	  $url = "http://".$_SERVER['HTTP_HOST'];
	  $str =$_SERVER['QUERY_STRING'];
	  
	  $pos=strpos($str,"page");
   	  if($pos!==false)
   	  {
   	   	$str=substr($str,0,$pos);
   	   	$url.=$str;
   	   	return $url;
   	  }
	  
	  $len = strlen($str);
	  $pos = strpos($str,'/',$len-1);
	  
	  if(is_bool($pos) && !$pos){
	    $url.=$_SERVER['QUERY_STRING'].'/';
	  }
	  else{
	  	$url.=$_SERVER['QUERY_STRING'];
	  }
      return $url;	
    }

    // ACCESSORS

    /***
     * Return a string representation of the URL
     * @returns string
     ***/
    function getUrl()
    {
        // $SEP = '=';
        $SEP = '/';

        if ($this->valid)
        {
            return $this->representation;
        }
        ksort($this->parameters);
        $result     = $this->base_name;

        //$result = substr_replace($result ,"",-1,1);
        // echo "base = ".$this->base_name;
        //echo "$result <br>";
        $parameters = array();
        foreach ($this->parameters as $key => $value)
        {
            if (isset($key) && $key != '')
            {
                array_push($parameters, $key . $SEP . urlencode($value));
            }
        }
        if (count($parameters))
        {
            $result .= '' . join('&', $parameters);
        }
        $this->representation = $result;
        $this->valid = true;

        // echo "$result <br>";
        return $result;
    }

    /***
     * Return a link to the Url
     * @param $string the HTML code for the link
     * @param $options the HTML options for the link, e.g.
     * <code>target="blank"</code>
     * @returns string
     ***/
    function getLink($string, $options = '')
    {
        return '<a href="' . $this->getUrl() . '"' .
               ($options != '' ? ' ' . trim($options) : '') .
               '>' . $string . '</a>';
    }
    /***
     * Return the base_name of this Url
     * @returns string
     ***/
    function getBasename()
    {
        return $this->base_name;
    }
    /***
     * Return a reference to this Url's parameters
     * @returns array
     ***/
    function &getParams()
    {
        return $this->parameters;
    }
    /***
     * Get the value of the specified Url parameter
     * @returns string
     ***/
    function getParam($name)
    {
        return $this->parameters[$name];
    }
    /***
     * Check whether a specific parameter exists in this Url
     * @returns bool
     ***/
    function hasParam($name)
    {
        return isset($this->parameters[$name]);
    }
}
?>
