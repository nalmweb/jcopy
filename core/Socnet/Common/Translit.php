<?	
/**
 * Class for Rus -> En Transliteration
 */
class Socnet_Common_Translit
{
	private $ru_big = array(
		'A'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'YO','Ж'=>'ZH','З'=>'Z',
		'И'=>'I','Й'=>'J','К'=>'K','Л'=>'L','М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R','С'=>'S',
		'Т'=>'T','У'=>'U','Ф'=>'F','Х'=>'H','Ц'=>'TZ','Ч'=>'CH','Ш'=>'SH','Щ'=>'SHCH','Ь'=>'',
		'Ы'=>'Y','Ъ'=>'','Э'=>'E','Ю'=>'YU','Я'=>'YA');
		
   private $ru_small = array(
				            'a'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'zh','з'=>'z','и'=>'i',
				            'й'=>'j','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t',
				            'у'=>'u','ф'=>'f','х'=>'h','ц'=>'tz','ч'=>'ch','ш'=>'sh','щ'=>'shch','ь'=>'','ы'=>'y','ъ'=>'',
				            'э'=>'e','ю'=>'yu','я'=>'ya'
			                );		
	
	
	private $ru = array('a','б','в','г','д','е','ё','ж','з','и',
				  		'й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ы','ъ','э','ю','я');
				   
    private $en= array('a','b','c','d','e','f','h','i','j','k',
					  'l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
					  
	private $str_ru = "aбвгдеёжзийклмнопрстуфхцчшщьыъэюя";
	
	//= array('');
	function __construct()
	{
	  
	}
	
	static function translit($str)
	{
		$ru_small = array(
			//'a' =>'a' ,'б' =>'b' ,'в'=>'v' , 'г'=>'g' , 'д' =>'d' ,'е' =>'e'
			  /*
				'a'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'zh','з'=>'z','и'=>'i',
				'й'=>'j','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t',
				'у'=>'u','ф'=>'f','х'=>'h','ц'=>'tz','ч'=>'ch','ш'=>'sh','щ'=>'shch','ь'=>'','ы'=>'y','ъ'=>'',
				'э'=>'e','ю'=>'yu','я'=>'ya'
			  */
			);
	  	$str = strtolower(preg_replace("'(\W)*'","",$str));
		return $str;
	}
	/**
	 * 
	 *
	 * @param unknown_type $str - unicode string
	 * @return russian text or initial letters
	 */
	static function getRusText2($str)
	{
		// %u043D%u0430%u0434%u043E
	$u2ru = array(  '0430'=>'a','0431'=>'б',
                    '0432'=>'в','0433'=>'г',
                    '0434'=>'д','0435'=>'е',
                    '0451'=>'ё','0436'=>'ж',
                    '0437'=>'з','0438'=>'и',
                    '0439'=>'й','043a'=>'к',
                    '043b'=>'л','043c'=>'м',
                    '043d'=>'н','043e'=>'о',
                    '043f'=>'п','0440'=>'р',
                    '0441'=>'с','0442'=>'т',
                    '0443'=>'у','0444'=>'ф',
                    '0445'=>'х','0446'=>'ц',
                    '0447'=>'ч','0448'=>'ш',
                    '0449'=>'щ','044c'=>'ь',
                    '044b'=>'ы','044a'=>'ъ',
                    '044d'=>'э','044e'=>'ю',
                    '044f'=>'я'
          );
          // '-' is allowed
          $str = strtolower  ($str);
          $str = str_replace ("-","X",$str);
          // remove all special chars
	      $str = preg_replace("'(\W)*'","",$str);
     	  $str = str_replace("X","-",$str);
          
     	   //echo "str = $str <br> ";
          $out = "";
          //$res = preg_split('/u(.*){4}/',$str,-1,PREG_SPLIT_NO_EMPTY);
          $res = preg_split('/(.*)(u([a-z][0-9]{3}))+/',$str,-1,PREG_SPLIT_NO_EMPTY);
          //echo "v = ".$u2ru[$res[0]];
          dump($res);
          
          if(empty($res)) return $str;
          
          foreach ($res as $value)
          {
	         if(empty($u2ru[$value]))
	             $out.=$value;
	         else
	             $out.= $u2ru[$value];
          }
          //$out = str_replace("-","",$out);
          return $out;
	}
	
	
	// $str:: %u0444%u044B%u0432%u0430& 
	/**
	 * get translit from russian text
	 *
	 * @param unknown_type $str
	 * @return unknown
	 */
	static function getTranslit($str)	
	{
        $un2tr  = array( '0430'=>'a','0431'=>'b',
                         '0432'=>'v','0433'=>'g',
                         '0434'=>'d','0435'=>'e',
                         '0436'=>'yo','0451'=>'yo',
                         '0437'=>'zh','0438'=>'z',
                         '0439'=>'i','043a'=>'j',
                         '043b'=>'k','043c'=>'l',
                         '043d'=>'m','043e'=>'n',
                         '043f'=>'o','0440'=>'p',
                         '0441'=>'r','0442'=>'s',
                         '0443'=>'t','0444'=>'u',
                         '0445'=>'f','0446'=>'h',
                         '0447'=>'tz','0448'=>'ch',
                         '0449'=>'sh','044a'=>'shch',
                         '044b'=>'-','044c'=>'y',
                         '044d'=>'-','044e'=>'e',
                         '044f'=>'ya'
                       );
		  // '-' is allowed
          $str = str_replace("-","X",$str);
          // remove all special chars
	      $str = preg_replace("'(\W)*'","",$str);
     	  $str = str_replace("X","-",$str);
          $out = "";
          
          $res = preg_split('/u/',$str,-1,PREG_SPLIT_NO_EMPTY);
          
          if(empty($res)) return "";
          
          foreach ($res as $value)
          {
	         if(empty($un2tr[$value]))
	             $out.=$value;
	         else
	             $out.= $un2tr[$value];	
          }
          
          $out = str_replace("-","",$out);
          return $out;
	}
	
	/**
	 * 
	 *  @param  string $str - a string with [a-яА-Я-]
	 *  @return unknown
	 */
	static function ru2translit($str)
	{
	  $ru = array('a'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'zh','з'=>'z','и'=>'i',
				  'й'=>'j','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t',
				  'у'=>'u','ф'=>'f','х'=>'h','ц'=>'tz','ч'=>'ch','ш'=>'sh','щ'=>'shch','ь'=>'','ы'=>'y','ъ'=>'',
				  'э'=>'e','ю'=>'yu','я'=>'ya');
     $str = strtolower($str);
     $res = preg_split('//',$str,-1,PREG_SPLIT_NO_EMPTY);
     $out = "";
    
      foreach ($res as $value)
      {
	     if(empty($ru[$value]))
	         $out.=$value;	
	     else
	         $out.= $ru[$value];	
      }
      return $out;
	}
	
	function removeSpaces()
	{
	   // $tpl = array("'(\W)*'");
	   //  remove all spec. chars: only [a-zа-я0-9]
	   $res = preg_replace("'(\W)*'","",$input);
	}
	
	
	/**
	 *   Clean <$str> FROM special chars 
	 *
	 */
	static function getRusText ($str)
	{
        // remove all special chars except % and -
	    $str = preg_replace("'(^%^-\W)*'","",$str);
	    $str = self::utf8RawUrlDecode($str);
	    // $str = iconv("ISO-8859-1", "UTF-8", $str);
	    // echo $str;
     	return $str;
	}
   /**
    *  Taken from php FAQ:
    *
    * @param unknown_type $source
    * @return unknown
    */
   static function utf8RawUrlDecode ($source)
   {
    $decodedStr = '';
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                // $entity =  $unicode . ';';
        		// encodes an ISO-8859-1 string to UTF-8
                $decodedStr .= utf8_Encode ($entity);;
                //$decodedStr .= chr($unicode-864);
                //$decodedStr .= chr($unicode-848);
                $pos += 4;
            }
            else
            {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        }
        else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    return $decodedStr;
  }

	
	
}
?>