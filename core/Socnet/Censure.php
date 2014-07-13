<?php

/**
 * Функция пытается определить наличие мата (нецензурных, матерных слов) в html-тексте
 * Возвращает false, если мат не обнаружен, иначе обнаруженное матерное слово.
 *
 * Алгоритм достаточно надежен и быстр, в т.ч. на больших объемах данных.
 * Метод обнаружения мата основывается на корнях и предлогах русского языка, а не на словаре.
 * Слова "лох", "хер", "залупа", "сука" матерными словами не считаются (см. словарь Даля)
 *
 * :TODO:
 * http://www.google.com/search?q=%F2%EE%EB%EA%EE%E2%FB%E9%20%F1%EB%EE%E2%E0%F0%FC%20%F0%F3%F1%F1%EA%EE%E3%EE%20%EC%E0%F2%E0&ie=cp1251&oe=UTF-8
 * http://www.awd.ru/dic.htm (Толковый словарь русского мата.)
 *
 * @param    string               $s  строка в кодировке UTF-8
 * @return   mixed(false/string)
 * @author   Nasibullin Rinat <n a s i b u l l i n  at starlink ru>
 * @charset  UTF-8
 * @version  3.0.18
 * @since    2005
 */
 
      //Socnet_Common_Translit
 
class Socnet_Censure
{
	
 public function __construct()
 {
 	
 }
  
	
 public static function censure($s)
 {
    #предлоги русского языка:
    #:TODO:
    #[всуо]|
    #по|за|на|об|до|от|вы|вс|вз|из|ис|
    #под|про|при|над|низ|раз|рас|воз|вос|
    #пооб|повы|пона|поза|недо|пере|одно|
    #полуза|произ|пораз|много|
    $pretext = '(?:' . implode('|', array(
        '[нn] ?(?:[аa]|[еe][иi]) ?',        #на, не, ни
        '(?:[пp]|[дdg])? ?[оo] ?',          #по, до, о
        '[зz3] ?[аa] ?',                    #за
        '[пp] ?[рr] ?[оo] ?',               #про
        '[оo] ?[тt] ?[ъь]? ?',              #от(ъ)
        '[пp] ?[оo] ?[дdg] ?[ъь] ?',        #под(ъ)
        '[пp] ?[еe] ?[рr] ?[еe] ?',         #пере
        '[oо] ?[дdg] ?[нn] ?[оo] ?',        #одно   (~ однохуйственно)
        '[мm] ?[нn] ?[оo] ?[гg] ?[оo] ?',   #много
    )) . ')';

    /*
    #слова, которые не должны быть матом:
    $valid_words = 'подстраХУЙ, страХУЕт, верХУЕт, лиХУЯ, '.
                   'оскорБЛЯТЬ, граБЛЯ, БЛЯха, оБЛЯДеть'.
                   'барСУКА, барСУЧКА, '.
                   'шЕБАЛа, нЕБАЛованый, перЕБАЛтывай, потрЕБИТель, '.
                   'ХЕРсонская, парикмаХЕР, стиХЕРов, '.
                   'ЛОХматый, чертопоЛОХ, ЗАЛУПАть, дЕБЕТ '.
                   'еЕ БЕТмэн ';
    */
    $badwords = '~'.
      #ХУЙ
      ' {PRETEXT}?(?!hue)[hхx] ?[уyu] ?[еeёйiяюju]|'.  #{PRETEXT}ху(я|й|ю|е|ё)

      #ПИЗДА
      ' {PRETEXT}?[пp] ?[иi] ?[зz3] ?[дd]|'.  #{PRETEXT}пизд

      #БЛЯ
      ' ([мm][оo][рpr][дd][оoаa])?[бb6] ?[лl] ?(я|ya)( ?[тд]| )|'. #бля(т|д), морд(о|а)бля(т|д)ская

      #ЕБИ
      #корректно обрабатываем фразу "..E БЕТа, гамма"
      ' {PRETEXT}?([eе] [бb6] [iиоoaаеeё]|[eе][бb6][iиоoaаеeё])|'.  #{PRETEXT}еб(и|о|а|е|ё)

      #ПИДОР
      #корректно обрабатываем фразу "pjpeg, application"
      '[п] ?[ieеи] ?[дdg] ?[eеaаoо] ?[rpр]|'.  #пид(о|е|а)р

      #FUCK
      ' ?f ?u ?[cс] ?k|'.  #fuck

      #МУДАК
      ' [мm] ?[уy] ?[дdg] ?[аa]|'.  #муда

      #ЖОПА
      #корректно обрабатываем фразу "Как решил тюменский арбитраЖ, О Переплате компания узнала только после акта сверки"
      #'[z3ж] ?h? ?[оo] ?[pп] ?[aаyуыiеeoо]|'.  #жоп(а|у|ы|е|о)
      '(?<!арбитра)[zж] ?h? ?[оo] ?[pп]'.  #жоп

      /*
      #ЛОХ
      ' л *[оo] *[хx] |'.  #кроме слова "ЛОХматый", "чертопоЛОХ" (растение)

      #СУКА
      '[^р] *[scс] *[yуu] *[kк] *[aаiи]|'. #сука (кроме слова "барсука" - это животное-грызун)
      '[^р] *[scс] *[yуu] *[4ч] *[кk]|'.   #сучк(и) (кроме слова "барсучка")

      #ХЕР
      ' {PRETEXT}?[хxh] *[еe] *[рpr]( *[нn] *(я|ya)| )|'. #{PRETEXT}хер(ня)

      #ЗАЛУПА
      ' [зz3] *[аa] *[лl] *[уy] *[пp] *[аa] '.
      */

      '~su';

    $badwords = str_replace('{PRETEXT}', $pretext, $badwords);

    #вырезаем все лишнее
    #скрипты не вырезаем, т.к. м.б. обходной маневр на с кодом на javascript:
    #<script>document.write('сло'+'во')</script>
    #хотя давать пользователю возможность использовать код на javascript нехорошо
    /*if (! function_exists('strip_tags_smart'))  #оптимизация скорости include_once
    {
        include_once 'strip_tags_smart.php';
    }
    */
    $s = self::strip_tags_smart($s, true, true, array('comment', 'style', 'map', 'frameset', 'object', 'applet'));

   /* if (! function_exists('utf8_html_entity_decode'))  #оптимизация скорости include_once
    {
        include_once 'utf8_html_entity_decode.php';
    }*/
    #заменяем html-сущности в "чистый" UTF-8
    $s = self::utf8_html_entity_decode($s, $is_htmlspecialchars = true);

    #неразрывный пробел заменяем на пробел ("\xc2\xa0" = &nbsp;)
    $trans = array(
        "\xc2\xad" => '',    #вырезаем "мягкие" переносы строк (&shy;)
        "\xcc\x81" => '',    #вырезаем знак ударения  (U+0301 «combining acute accent»)
        #"\xc2\xa0" => ' ',   #заменяем неразрывный пробел на обычный
    );
    $s = str_replace(array_keys($trans), array_values($trans), $s);

    /*if (! function_exists('utf8_convert_case'))  #оптимизация скорости include_once
    {
        include_once 'utf8_convert_case.php';
    }*/
    
    $s = self::utf8_convert_case($s, CASE_LOWER);

    #получаем в массив только буквы и цифры
    #"с_л@о#во,с\xc2\xa7лово.Слово" -> "слово слово слово"
    preg_match_all('/(?> \xd0[\xb0-\xbf]|\xd1[\x80-\x8f\x91]  #[а-я]
                      |  [a-z\d]+
                      )+
                    /sx', $s, $m);
    $s = implode(' ', $m[0]);

    #убираем все повторяющиеся символы
    #"сллоооовоо   слово" -> "слово слово"
    $s = preg_replace('/(  [\xd0\xd1][\x80-\xbf]  #оптимизированное [а-я]
                         | [a-z\d]
                         ) \\1+
                       /sx', '$1', $s);
    //d($s);
    if (preg_match($badwords, ' ' . $s . ' ', $m))
    {
        #d($m);
        return trim($m[0]);
    }
    return false;
   }
   
   /**
 * ����� ����������� ������ strip_tags() ��� ����������� ��������� ����� �� html ����.
 * ������� strip_tags(), � ����������� �� ���������, ����� �������� �� ���������.
 * ����������:
 *   - ��������� �������������� ��������� ���� "a < b > c"
 *   - ��������� �������������� "�������" html, ����� � ��������� ��������� ����� ����� ����������� ������� < >
 *   - ���������� �����������, �������, �����, PHP, Perl, ASP ���, MS Word ����
 *   - ������������� ������������� �����, ���� �� �������� html ���
 *   - ������ �� �������� ����: "<<fake>script>alert('hi')</</fake>script>"
 *
 * @param   string  $s
 * @param   array   $allowable_tags     ������ �����, ������� �� ����� ��������
 * @param   bool    $is_format_spaces   ������������� ������� � �������� �����?
 *                                      ����� ������������� �������������, ���� �� �������� html ���:
 *                                      ��� ������ �� ������ (plain) ����������� ������������ ���� ������ � �������� �� �����
 *                                      ������� �������, �������� ����������� text/html � text/plain
 * @param   array   $pair_tags   ������ ��� ������ �����, ������� ����� ������� ������ � ����������
 *                               ��. �������� �� ���������
 * @param   array   $para_tags   ������ ��� ������ �����, ������� ����� �������������� ��� ��������� (���� $is_format_spaces = true)
 *                               ��. �������� �� ���������
 * @return  string
 *
 * @author   Nasibullin Rinat <n a s i b u l l i n  at starlink ru>
 * @charset  ANSI
 * @version  4.0.1
 */
public static function strip_tags_smart(
    $s,
    $allowable_tags = false,
    $is_format_spaces = false,
    $pair_tags = array('script', 'style', 'map', 'iframe', 'frameset', 'object', 'applet', 'comment', 'button'),
    $para_tags = array('p', 'td', 'th', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'form', 'title')
)
{
    static $_callback_type  = false;
    static $_allowable_tags = false;
    static $_para_tags      = false;

    if (is_array($s) && $_callback_type === 'strip_tags')
    {
        $tag = strtolower($s[1]);
        if (is_array($_allowable_tags) &&
            (array_key_exists($tag, $_allowable_tags) || array_key_exists('<' . trim(strtolower($s[0]), '< />') . '>', $_allowable_tags))
            )
        {
            return $s[0];
        }
        if ($tag == 'br')
        {
            return "\r\n";
        }
        if (is_array($_para_tags) && array_key_exists($tag, $_para_tags))
        {
            return "\r\n\r\n";
        }
        return '';
    }

    if (strpos($s, '<') === false || strpos($s, '>') === false)  #����������� ��������
    {
        #���� �� �������
        return $s;
    }
    #���������� ��������� ��� ��������� �����
    static $re_attrs_fast = '(?> (?>[\x20\r\n\t]+)  #���������� ������� �.�. �����������
                                 (?> [^>"\']+ | "[^"]*" | \'[^\']*\' )*
                             )?';
    #�������� ���� (�����������, �����������, !DOCTYPE, MS Word namespace)
    $re_tags = '/<[\/\!]? ([a-zA-Z][a-zA-Z\d]* (?>\:[a-zA-Z][a-zA-Z\d]*)?)' . $re_attrs_fast . '\/?>/sx';

    $patterns = array(
        '/<([\?\%]) .*? \\1>/sx',     #���������� PHP, Perl, ASP ���
        '/<\!\[CDATA\[ .*? \]\]>/sx', #����� CDATA
        #'/<\!\[  [\x20\r\n\t]* [a-zA-Z] .*?  \]>/sx',  #:DEPRECATED: MS Word ���� ���� <![if! vml]>...<![endif]>

        '/<\!--.*?-->/s', #�����������

        #MS Word ���� ���� "<![if! vml]>...<![endif]>",
        #�������� ���������� ���� ��� IE ���� "<!--[if lt IE 7]>...<![endif]-->"
        '/<\! (?>--)?
              \[
              (?> [^\]"\']+ | "[^"]*" | \'[^\']*\' )*
              \]
              (?>--)?
         >/sx',
    );
    if (is_array($pair_tags) && count($pair_tags) > 0)
    {
        #������ ���� ������ � ����������:
        foreach ($pair_tags as $k => $v)
        {
            $pair_tags[$k] = preg_quote($v, '/');
        }
        $patterns[] = '/<((?i:' . implode('|', $pair_tags) . '))' . $re_attrs_fast . '> .*? <\/(?i:\\1)' . $re_attrs_fast . '>/sx';
    }
    #d($patterns);

    $i = 0; #������ �� ������������
    $max = 99;
    while ($i < $max)
    {
        $s2 = preg_replace($patterns, '', $s);

        if ($i == 0)
        {
            $is_html = ($s2 != $s || preg_match($re_tags, $s2));
            if ($is_html)
            {
                #������� �� ������ �������� ����� ����������� ��������� \x20, \r, \n, \t
                #���� �� ������ ������ ������ ������� �������������� ��� ���� ������
                #$s = str_replace(array("\r", "\n", "\t"), ' ', $s);
                $s2 = strtr($s2, "\r\n\t", '   ');

                #������ �����, ������� �� ����� ��������
                if (is_array($allowable_tags))
                {
                    $_allowable_tags = array_flip($allowable_tags);
                }

                #������ ����, ������� ����� �������������� ��� ���������
                if (is_array($para_tags))
                {
                    $_para_tags = array_flip($para_tags);
                }
            }
        }#if

        #��������� �����
        if ($is_html)
        {
            $_callback_type = 'strip_tags';
            $s2 = preg_replace_callback($re_tags, __FUNCTION__, $s2);
            $_callback_type = false;
        }

        if ($s === $s2)
        {
            break;
        }
        $s = $s2; $i++;
    }#while
    if ($i >= $max)
    {
        #too many cycles for replace...
        $s = strip_tags($s);
    }

    if ($is_format_spaces || $is_html)
    {
        #�������� ����������� �������
        $s = preg_replace('/\x20\x20+/s', ' ', trim($s));
        #�������� ������� � ������ � � ����� �����
        $s = str_replace(array("\r\n\x20", "\x20\r\n"), "\r\n", $s);
        #�������� 2 � ����� ��������� ����� �� 2 �������� �����
        $s = preg_replace('/\r\n[\r\n]+/s', "\r\n\r\n", $s);
    }
    return $s;
   }
   
   
   
   /**
 * ������������ ������� ���� � ������ � ��������� UTF-8
 *
 * @param    string      $s     ������
 * @param    int         $mode  {CASE_LOWER|CASE_UPPER}
 * @return   string
 * @link     http://www.unicode.org/charts/PDF/U0400.pdf
 *
 * @author   Nasibullin Rinat <n a s i b u l l i n  at starlink ru>
 * @charset  ANSI
 * @link     http://ru.wikipedia.org/wiki/ISO_639-1
 * @version  1.2.1
 */
public static function utf8_convert_case($s, $mode)
{

/**
 * UTF-8 Case lookup table
 *
 * This lookuptable defines the upper case letters to their correspponding
 * lower case letter in UTF-8
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
/***
$UTF8_LOWER_TO_UPPER = array(
  0x0061=>0x0041, 0x03C6=>0x03A6, 0x0163=>0x0162, 0x00E5=>0x00C5, 0x0062=>0x0042,
  0x013A=>0x0139, 0x00E1=>0x00C1, 0x0142=>0x0141, 0x03CD=>0x038E, 0x0101=>0x0100,
  0x0491=>0x0490, 0x03B4=>0x0394, 0x015B=>0x015A, 0x0064=>0x0044, 0x03B3=>0x0393,
  0x00F4=>0x00D4, 0x044A=>0x042A, 0x0439=>0x0419, 0x0113=>0x0112, 0x043C=>0x041C,
  0x015F=>0x015E, 0x0144=>0x0143, 0x00EE=>0x00CE, 0x045E=>0x040E, 0x044F=>0x042F,
  0x03BA=>0x039A, 0x0155=>0x0154, 0x0069=>0x0049, 0x0073=>0x0053, 0x1E1F=>0x1E1E,
  0x0135=>0x0134, 0x0447=>0x0427, 0x03C0=>0x03A0, 0x0438=>0x0418, 0x00F3=>0x00D3,
  0x0440=>0x0420, 0x0454=>0x0404, 0x0435=>0x0415, 0x0449=>0x0429, 0x014B=>0x014A,
  0x0431=>0x0411, 0x0459=>0x0409, 0x1E03=>0x1E02, 0x00F6=>0x00D6, 0x00F9=>0x00D9,
  0x006E=>0x004E, 0x0451=>0x0401, 0x03C4=>0x03A4, 0x0443=>0x0423, 0x015D=>0x015C,
  0x0453=>0x0403, 0x03C8=>0x03A8, 0x0159=>0x0158, 0x0067=>0x0047, 0x00E4=>0x00C4,
  0x03AC=>0x0386, 0x03AE=>0x0389, 0x0167=>0x0166, 0x03BE=>0x039E, 0x0165=>0x0164,
  0x0117=>0x0116, 0x0109=>0x0108, 0x0076=>0x0056, 0x00FE=>0x00DE, 0x0157=>0x0156,
  0x00FA=>0x00DA, 0x1E61=>0x1E60, 0x1E83=>0x1E82, 0x00E2=>0x00C2, 0x0119=>0x0118,
  0x0146=>0x0145, 0x0070=>0x0050, 0x0151=>0x0150, 0x044E=>0x042E, 0x0129=>0x0128,
  0x03C7=>0x03A7, 0x013E=>0x013D, 0x0442=>0x0422, 0x007A=>0x005A, 0x0448=>0x0428,
  0x03C1=>0x03A1, 0x1E81=>0x1E80, 0x016D=>0x016C, 0x00F5=>0x00D5, 0x0075=>0x0055,
  0x0177=>0x0176, 0x00FC=>0x00DC, 0x1E57=>0x1E56, 0x03C3=>0x03A3, 0x043A=>0x041A,
  0x006D=>0x004D, 0x016B=>0x016A, 0x0171=>0x0170, 0x0444=>0x0424, 0x00EC=>0x00CC,
  0x0169=>0x0168, 0x03BF=>0x039F, 0x006B=>0x004B, 0x00F2=>0x00D2, 0x00E0=>0x00C0,
  0x0434=>0x0414, 0x03C9=>0x03A9, 0x1E6B=>0x1E6A, 0x00E3=>0x00C3, 0x044D=>0x042D,
  0x0436=>0x0416, 0x01A1=>0x01A0, 0x010D=>0x010C, 0x011D=>0x011C, 0x00F0=>0x00D0,
  0x013C=>0x013B, 0x045F=>0x040F, 0x045A=>0x040A, 0x00E8=>0x00C8, 0x03C5=>0x03A5,
  0x0066=>0x0046, 0x00FD=>0x00DD, 0x0063=>0x0043, 0x021B=>0x021A, 0x00EA=>0x00CA,
  0x03B9=>0x0399, 0x017A=>0x0179, 0x00EF=>0x00CF, 0x01B0=>0x01AF, 0x0065=>0x0045,
  0x03BB=>0x039B, 0x03B8=>0x0398, 0x03BC=>0x039C, 0x045C=>0x040C, 0x043F=>0x041F,
  0x044C=>0x042C, 0x00FE=>0x00DE, 0x00F0=>0x00D0, 0x1EF3=>0x1EF2, 0x0068=>0x0048,
  0x00EB=>0x00CB, 0x0111=>0x0110, 0x0433=>0x0413, 0x012F=>0x012E, 0x00E6=>0x00C6,
  0x0078=>0x0058, 0x0161=>0x0160, 0x016F=>0x016E, 0x03B1=>0x0391, 0x0457=>0x0407,
  0x0173=>0x0172, 0x00FF=>0x0178, 0x006F=>0x004F, 0x043B=>0x041B, 0x03B5=>0x0395,
  0x0445=>0x0425, 0x0121=>0x0120, 0x017E=>0x017D, 0x017C=>0x017B, 0x03B6=>0x0396,
  0x03B2=>0x0392, 0x03AD=>0x0388, 0x1E85=>0x1E84, 0x0175=>0x0174, 0x0071=>0x0051,
  0x0437=>0x0417, 0x1E0B=>0x1E0A, 0x0148=>0x0147, 0x0105=>0x0104, 0x0458=>0x0408,
  0x014D=>0x014C, 0x00ED=>0x00CD, 0x0079=>0x0059, 0x010B=>0x010A, 0x03CE=>0x038F,
  0x0072=>0x0052, 0x0430=>0x0410, 0x0455=>0x0405, 0x0452=>0x0402, 0x0127=>0x0126,
  0x0137=>0x0136, 0x012B=>0x012A, 0x03AF=>0x038A, 0x044B=>0x042B, 0x006C=>0x004C,
  0x03B7=>0x0397, 0x0125=>0x0124, 0x0219=>0x0218, 0x00FB=>0x00DB, 0x011F=>0x011E,
  0x043E=>0x041E, 0x1E41=>0x1E40, 0x03BD=>0x039D, 0x0107=>0x0106, 0x03CB=>0x03AB,
  0x0446=>0x0426, 0x00FE=>0x00DE, 0x00E7=>0x00C7, 0x03CA=>0x03AA, 0x0441=>0x0421,
  0x0432=>0x0412, 0x010F=>0x010E, 0x00F8=>0x00D8, 0x0077=>0x0057, 0x011B=>0x011A,
  0x0074=>0x0054, 0x006A=>0x004A, 0x045B=>0x040B, 0x0456=>0x0406, 0x0103=>0x0102,
  0x03BB=>0x039B, 0x00F1=>0x00D1, 0x043D=>0x041D, 0x03CC=>0x038C, 0x00E9=>0x00C9,
  0x00F0=>0x00D0, 0x0457=>0x0407, 0x0123=>0x0122,
);
***/

/**
 * UTF-8 array of common special characters
 *
 * This array should contain all special characters (not a letter or digit)
 * defined in the various local charsets - it's not a complete list of non-alphanum
 * characters in UTF-8. It's not perfect but should match most cases of special
 * chars.
 *
 * The controlchars 0x00 to 0x19 are _not_ included in this array. The space 0x20 is!
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 * @see    utf8_stripspecials()
 */
/***
$UTF8_SPECIAL_CHARS = array(
  0x001a, 0x001b, 0x001c, 0x001d, 0x001e, 0x001f, 0x0020, 0x0021, 0x0022, 0x0023,
  0x0024, 0x0025, 0x0026, 0x0027, 0x0028, 0x0029, 0x002a, 0x002b, 0x002c, 0x002d,
  0x002e, 0x002f, 0x003a, 0x003b, 0x003c, 0x003d, 0x003e, 0x003f, 0x0040, 0x005b,
  0x005c, 0x005d, 0x005e, 0x005f, 0x0060, 0x007b, 0x007c, 0x007d, 0x007e,
  0x007f, 0x0080, 0x0081, 0x0082, 0x0083, 0x0084, 0x0085, 0x0086, 0x0087, 0x0088,
  0x0089, 0x008a, 0x008b, 0x008c, 0x008d, 0x008e, 0x008f, 0x0090, 0x0091, 0x0092,
        0x0093, 0x0094, 0x0095, 0x0096, 0x0097, 0x0098, 0x0099, 0x009a, 0x009b, 0x009c,
        0x009d, 0x009e, 0x009f, 0x00a0, 0x00a1, 0x00a2, 0x00a3, 0x00a4, 0x00a5, 0x00a6,
        0x00a7, 0x00a8, 0x00a9, 0x00aa, 0x00ab, 0x00ac, 0x00ad, 0x00ae, 0x00af, 0x00b0,
        0x00b1, 0x00b2, 0x00b3, 0x00b4, 0x00b5, 0x00b6, 0x00b7, 0x00b8, 0x00b9, 0x00ba,
        0x00bb, 0x00bc, 0x00bd, 0x00be, 0x00bf, 0x00d7, 0x00f7, 0x02c7, 0x02d8, 0x02d9,
        0x02da, 0x02db, 0x02dc, 0x02dd, 0x0300, 0x0301, 0x0303, 0x0309, 0x0323, 0x0384,
        0x0385, 0x0387, 0x03b2, 0x03c6, 0x03d1, 0x03d2, 0x03d5, 0x03d6, 0x05b0, 0x05b1,
        0x05b2, 0x05b3, 0x05b4, 0x05b5, 0x05b6, 0x05b7, 0x05b8, 0x05b9, 0x05bb, 0x05bc,
        0x05bd, 0x05be, 0x05bf, 0x05c0, 0x05c1, 0x05c2, 0x05c3, 0x05f3, 0x05f4, 0x060c,
        0x061b, 0x061f, 0x0640, 0x064b, 0x064c, 0x064d, 0x064e, 0x064f, 0x0650, 0x0651,
        0x0652, 0x066a, 0x0e3f, 0x200c, 0x200d, 0x200e, 0x200f, 0x2013, 0x2014, 0x2015,
        0x2017, 0x2018, 0x2019, 0x201a, 0x201c, 0x201d, 0x201e, 0x2020, 0x2021, 0x2022,
        0x2026, 0x2030, 0x2032, 0x2033, 0x2039, 0x203a, 0x2044, 0x20a7, 0x20aa, 0x20ab,
        0x20ac, 0x2116, 0x2118, 0x2122, 0x2126, 0x2135, 0x2190, 0x2191, 0x2192, 0x2193,
        0x2194, 0x2195, 0x21b5, 0x21d0, 0x21d1, 0x21d2, 0x21d3, 0x21d4, 0x2200, 0x2202,
        0x2203, 0x2205, 0x2206, 0x2207, 0x2208, 0x2209, 0x220b, 0x220f, 0x2211, 0x2212,
        0x2215, 0x2217, 0x2219, 0x221a, 0x221d, 0x221e, 0x2220, 0x2227, 0x2228, 0x2229,
        0x222a, 0x222b, 0x2234, 0x223c, 0x2245, 0x2248, 0x2260, 0x2261, 0x2264, 0x2265,
        0x2282, 0x2283, 0x2284, 0x2286, 0x2287, 0x2295, 0x2297, 0x22a5, 0x22c5, 0x2310,
        0x2320, 0x2321, 0x2329, 0x232a, 0x2469, 0x2500, 0x2502, 0x250c, 0x2510, 0x2514,
        0x2518, 0x251c, 0x2524, 0x252c, 0x2534, 0x253c, 0x2550, 0x2551, 0x2552, 0x2553,
        0x2554, 0x2555, 0x2556, 0x2557, 0x2558, 0x2559, 0x255a, 0x255b, 0x255c, 0x255d,
        0x255e, 0x255f, 0x2560, 0x2561, 0x2562, 0x2563, 0x2564, 0x2565, 0x2566, 0x2567,
        0x2568, 0x2569, 0x256a, 0x256b, 0x256c, 0x2580, 0x2584, 0x2588, 0x258c, 0x2590,
        0x2591, 0x2592, 0x2593, 0x25a0, 0x25b2, 0x25bc, 0x25c6, 0x25ca, 0x25cf, 0x25d7,
        0x2605, 0x260e, 0x261b, 0x261e, 0x2660, 0x2663, 0x2665, 0x2666, 0x2701, 0x2702,
        0x2703, 0x2704, 0x2706, 0x2707, 0x2708, 0x2709, 0x270c, 0x270d, 0x270e, 0x270f,
        0x2710, 0x2711, 0x2712, 0x2713, 0x2714, 0x2715, 0x2716, 0x2717, 0x2718, 0x2719,
        0x271a, 0x271b, 0x271c, 0x271d, 0x271e, 0x271f, 0x2720, 0x2721, 0x2722, 0x2723,
        0x2724, 0x2725, 0x2726, 0x2727, 0x2729, 0x272a, 0x272b, 0x272c, 0x272d, 0x272e,
        0x272f, 0x2730, 0x2731, 0x2732, 0x2733, 0x2734, 0x2735, 0x2736, 0x2737, 0x2738,
        0x2739, 0x273a, 0x273b, 0x273c, 0x273d, 0x273e, 0x273f, 0x2740, 0x2741, 0x2742,
        0x2743, 0x2744, 0x2745, 0x2746, 0x2747, 0x2748, 0x2749, 0x274a, 0x274b, 0x274d,
        0x274f, 0x2750, 0x2751, 0x2752, 0x2756, 0x2758, 0x2759, 0x275a, 0x275b, 0x275c,
        0x275d, 0x275e, 0x2761, 0x2762, 0x2763, 0x2764, 0x2765, 0x2766, 0x2767, 0x277f,
        0x2789, 0x2793, 0x2794, 0x2798, 0x2799, 0x279a, 0x279b, 0x279c, 0x279d, 0x279e,
        0x279f, 0x27a0, 0x27a1, 0x27a2, 0x27a3, 0x27a4, 0x27a5, 0x27a6, 0x27a7, 0x27a8,
        0x27a9, 0x27aa, 0x27ab, 0x27ac, 0x27ad, 0x27ae, 0x27af, 0x27b1, 0x27b2, 0x27b3,
        0x27b4, 0x27b5, 0x27b6, 0x27b7, 0x27b8, 0x27b9, 0x27ba, 0x27bb, 0x27bc, 0x27bd,
        0x27be, 0xf6d9, 0xf6da, 0xf6db, 0xf8d7, 0xf8d8, 0xf8d9, 0xf8da, 0xf8db, 0xf8dc,
        0xf8dd, 0xf8de, 0xf8df, 0xf8e0, 0xf8e1, 0xf8e2, 0xf8e3, 0xf8e4, 0xf8e5, 0xf8e6,
        0xf8e7, 0xf8e8, 0xf8e9, 0xf8ea, 0xf8eb, 0xf8ec, 0xf8ed, 0xf8ee, 0xf8ef, 0xf8f0,
        0xf8f1, 0xf8f2, 0xf8f3, 0xf8f4, 0xf8f5, 0xf8f6, 0xf8f7, 0xf8f8, 0xf8f9, 0xf8fa,
        0xf8fb, 0xf8fc, 0xf8fd, 0xf8fe, 0xfe7c, 0xfe7d,
);
***/

    #������� ����������� ��������
    static $trans = array(
        #CASE_UPPER => CASE_LOWER
        #en (���������� ��������)
        "\x41" => "\x61", #a
        "\x42" => "\x62", #b
        "\x43" => "\x63", #c
        "\x44" => "\x64", #d
        "\x45" => "\x65", #e
        "\x46" => "\x66", #f
        "\x47" => "\x67", #g
        "\x48" => "\x68", #h
        "\x49" => "\x69", #i
        "\x4a" => "\x6a", #j
        "\x4b" => "\x6b", #k
        "\x4c" => "\x6c", #l
        "\x4d" => "\x6d", #m
        "\x4e" => "\x6e", #n
        "\x4f" => "\x6f", #o
        "\x50" => "\x70", #p
        "\x51" => "\x71", #q
        "\x52" => "\x72", #r
        "\x53" => "\x73", #s
        "\x54" => "\x74", #t
        "\x55" => "\x75", #u
        "\x57" => "\x77", #w
        "\x56" => "\x76", #v
        "\x58" => "\x78", #x
        "\x59" => "\x79", #y
        "\x5a" => "\x7a", #z

        #ru (������� ���������)
        "\xd0\x81" => "\xd1\x91", #�
        "\xd0\x90" => "\xd0\xb0", #�
        "\xd0\x91" => "\xd0\xb1", #�
        "\xd0\x92" => "\xd0\xb2", #�
        "\xd0\x93" => "\xd0\xb3", #�
        "\xd0\x94" => "\xd0\xb4", #�
        "\xd0\x95" => "\xd0\xb5", #�
        "\xd0\x96" => "\xd0\xb6", #�
        "\xd0\x97" => "\xd0\xb7", #�
        "\xd0\x98" => "\xd0\xb8", #�
        "\xd0\x99" => "\xd0\xb9", #�
        "\xd0\x9a" => "\xd0\xba", #�
        "\xd0\x9b" => "\xd0\xbb", #�
        "\xd0\x9c" => "\xd0\xbc", #�
        "\xd0\x9d" => "\xd0\xbd", #�
        "\xd0\x9e" => "\xd0\xbe", #�
        "\xd0\x9f" => "\xd0\xbf", #�

        "\xd0\xa0" => "\xd1\x80", #�
        "\xd0\xa1" => "\xd1\x81", #�
        "\xd0\xa2" => "\xd1\x82", #�
        "\xd0\xa3" => "\xd1\x83", #�
        "\xd0\xa4" => "\xd1\x84", #�
        "\xd0\xa5" => "\xd1\x85", #�
        "\xd0\xa6" => "\xd1\x86", #�
        "\xd0\xa7" => "\xd1\x87", #�
        "\xd0\xa8" => "\xd1\x88", #�
        "\xd0\xa9" => "\xd1\x89", #�
        "\xd0\xaa" => "\xd1\x8a", #�
        "\xd0\xab" => "\xd1\x8b", #�
        "\xd0\xac" => "\xd1\x8c", #�
        "\xd0\xad" => "\xd1\x8d", #�
        "\xd0\xae" => "\xd1\x8e", #�
        "\xd0\xaf" => "\xd1\x8f", #�

        #tt (���������, ���������� ���������)
        "\xd2\x96" => "\xd2\x97", #� � ���������    &#1174; => &#1175;
        "\xd2\xa2" => "\xd2\xa3", #� � ���������    &#1186; => &#1187;
        "\xd2\xae" => "\xd2\xaf", #y                &#1198; => &#1199;
        "\xd2\xba" => "\xd2\xbb", #h ������         &#1210; => &#1211;
        "\xd3\x98" => "\xd3\x99", #�                &#1240; => &#1241;
        "\xd3\xa8" => "\xd3\xa9", #o �������������  &#1256; => &#1257;

        #uk (���������� ���������)
        "\xd2\x90" => "\xd2\x91",  #� � ���������
        "\xd0\x84" => "\xd1\x94",  #� ���������� ���������
        "\xd0\x86" => "\xd1\x96",  #� � ����� ������
        "\xd0\x87" => "\xd1\x97",  #� � ����� �������

        #be (����������� ���������)
        "\xd0\x8e" => "\xd1\x9e",  #� � �������� ��� ������

        #tr,de,es (��������, ��������, ���������, ����������� ��������)
        "\xc3\x84" => "\xc3\xa4", #a ������          &#196; => &#228;  (��������)
        "\xc3\x87" => "\xc3\xa7", #c � ���������     &#199; => &#231;  (��������, �����������)
        "\xc3\x91" => "\xc3\xb1", #n � �������       &#209; => &#241;  (��������, ���������)
        "\xc3\x96" => "\xc3\xb6", #o ������          &#214; => &#246;  (��������)
        "\xc3\x9c" => "\xc3\xbc", #u ������          &#220; => &#252;  (��������, �����������)
        "\xc4\x9e" => "\xc4\x9f", #g ������          &#286; => &#287;  (��������)
        "\xc4\xb0" => "\xc4\xb1", #i c ������ � ���  &#304; => &#305;  (��������)
        "\xc5\x9e" => "\xc5\x9f", #s � ���������     &#350; => &#351;  (��������)

        #hr (���������� ��������)
        "\xc4\x8c" => "\xc4\x8d",  #c � �������� ��� ������
        "\xc4\x86" => "\xc4\x87",  #c � ���������
        "\xc4\x90" => "\xc4\x91",  #d �������������
        "\xc5\xa0" => "\xc5\xa1",  #s � �������� ��� ������
        "\xc5\xbd" => "\xc5\xbe",  #z � �������� ��� ������

        #fr (����������� ��������)
        "\xc3\x80" => "\xc3\xa0",  #a � ��������� � ��. �������
        "\xc3\x82" => "\xc3\xa2",  #a � �������
        "\xc3\x86" => "\xc3\xa6",  #ae �����������
        "\xc3\x88" => "\xc3\xa8",  #e � ��������� � ��. �������
        "\xc3\x89" => "\xc3\xa9",  #e � ���������
        "\xc3\x8a" => "\xc3\xaa",  #e � �������
        "\xc3\x8b" => "\xc3\xab",  #�
        "\xc3\x8e" => "\xc3\xae",  #i � �������
        "\xc3\x8f" => "\xc3\xaf",  #i ������
        "\xc3\x94" => "\xc3\xb4",  #o � �������
        "\xc5\x92" => "\xc5\x93",  #ce �����������
        "\xc3\x99" => "\xc3\xb9",  #u � ��������� � ��. �������
        "\xc3\x9b" => "\xc3\xbb",  #u � �������
        "\xc5\xb8" => "\xc3\xbf",  #y ������

        #xx (������ ����)
        #"" => "",  #

    );
    #d($trans);

    #������� � str_replace() ������ �������� �������, ��� � strtr()
    if ($mode == CASE_UPPER)
    {
        if (function_exists('mb_strtoupper'))
        {
            return mb_strtoupper($s, 'utf-8');
        }
        #if (ctype_alnum($s))  #����������� ��� /^[a-zA-Z\d]*$/s
        if (preg_match('/^[\x20-\x7e]*$/', $s))  #�����, ��� �������? (:TODO:)
        {
            return strtoupper($s);
        }
        $s = str_replace(array_values($trans), array_keys($trans), $s);
    }
    elseif ($mode == CASE_LOWER)
    {
        if (function_exists('mb_strtolower'))
        {
            return mb_strtolower($s, 'utf-8');
        }
        #if (ctype_alnum($s))  #����������� ��� /^[a-zA-Z\d]*$/s
        if (preg_match('/^[\x20-\x7e]*$/', $s))  #�����, ��� �������? (:TODO:)
        {
            return strtolower($s);
        }
        $s = str_replace(array_keys($trans), array_values($trans), $s);
    }
    else
    {
        trigger_error('Parameter 2 should be a constant of CASE_LOWER or CASE_UPPER!', E_USER_WARNING);
        return $s;
    }

    return $s;
	}
	
	public static function utf8_lowercase($s)
	{
	    return utf8_convert_case($s, CASE_LOWER);
	}
	
	public static function utf8_uppercase($s)
	{
	    return utf8_convert_case($s, CASE_UPPER);
	}
	
	/**
 * Convert all HTML entities to UTF-8 characters
 * ������� ���������� ������� ������ ����������� ���������, ��� ����������� html_entity_decode()
 * ��� dec � hex �������� ��� �� ����������� � UTF-8.
 *
 * @param    string   $s
 * @param    bool     $is_htmlspecialchars   ������������ ����������� html ��������? (&lt; &gt; &amp; &quot;)
 * @return   string
 * @link     http://www.htmlhelp.com/reference/html40/entities/
 * @link     http://msdn.microsoft.com/workshop/author/dhtml/reference/charsets/charset1.asp?frame=true
 * @link     http://msdn.microsoft.com/workshop/author/dhtml/reference/charsets/charset2.asp?frame=true
 * @link     http://msdn.microsoft.com/workshop/author/dhtml/reference/charsets/charset3.asp?frame=true
 *
 * @author   Nasibullin Rinat <n a s i b u l l i n  at starlink ru>
 * @charset  ANSI
 * @version  2.1.8
 */
public static function utf8_html_entity_decode($s, $is_htmlspecialchars = false)
{
    #����������� ��������
    if (strlen($s) < 4  #�� ����������� ����� �������� - 4 �����: &#d; &xx;
        || strpos($s, '&') === false || strpos($s, ';') === false)
    {
        return $s;
    }
    $table = array(
      #Latin-1 Entities:
        '&nbsp;'   => "\xc2\xa0",  #no-break space = non-breaking space
        '&iexcl;'  => "\xc2\xa1",  #inverted exclamation mark
        '&cent;'   => "\xc2\xa2",  #cent sign
        '&pound;'  => "\xc2\xa3",  #pound sign
        '&curren;' => "\xc2\xa4",  #currency sign
        '&yen;'    => "\xc2\xa5",  #yen sign = yuan sign
        '&brvbar;' => "\xc2\xa6",  #broken bar = broken vertical bar
        '&sect;'   => "\xc2\xa7",  #section sign
        '&uml;'    => "\xc2\xa8",  #diaeresis = spacing diaeresis
        '&copy;'   => "\xc2\xa9",  #copyright sign
        '&ordf;'   => "\xc2\xaa",  #feminine ordinal indicator
        '&laquo;'  => "\xc2\xab",  #left-pointing double angle quotation mark = left pointing guillemet (�)
        '&not;'    => "\xc2\xac",  #not sign
        '&shy;'    => "\xc2\xad",  #soft hyphen = discretionary hyphen
        '&reg;'    => "\xc2\xae",  #registered sign = registered trade mark sign
        '&macr;'   => "\xc2\xaf",  #macron = spacing macron = overline = APL overbar
        '&deg;'    => "\xc2\xb0",  #degree sign
        '&plusmn;' => "\xc2\xb1",  #plus-minus sign = plus-or-minus sign
        '&sup2;'   => "\xc2\xb2",  #superscript two = superscript digit two = squared
        '&sup3;'   => "\xc2\xb3",  #superscript three = superscript digit three = cubed
        '&acute;'  => "\xc2\xb4",  #acute accent = spacing acute
        '&micro;'  => "\xc2\xb5",  #micro sign
        '&para;'   => "\xc2\xb6",  #pilcrow sign = paragraph sign
        '&middot;' => "\xc2\xb7",  #middle dot = Georgian comma = Greek middle dot
        '&cedil;'  => "\xc2\xb8",  #cedilla = spacing cedilla
        '&sup1;'   => "\xc2\xb9",  #superscript one = superscript digit one
        '&ordm;'   => "\xc2\xba",  #masculine ordinal indicator
        '&raquo;'  => "\xc2\xbb",  #right-pointing double angle quotation mark = right pointing guillemet (�)
        '&frac14;' => "\xc2\xbc",  #vulgar fraction one quarter = fraction one quarter
        '&frac12;' => "\xc2\xbd",  #vulgar fraction one half = fraction one half
        '&frac34;' => "\xc2\xbe",  #vulgar fraction three quarters = fraction three quarters
        '&iquest;' => "\xc2\xbf",  #inverted question mark = turned question mark
      #Latin capital letter
        '&Agrave;' => "\xc3\x80",  #Latin capital letter A with grave = Latin capital letter A grave
        '&Aacute;' => "\xc3\x81",  #Latin capital letter A with acute
        '&Acirc;'  => "\xc3\x82",  #Latin capital letter A with circumflex
        '&Atilde;' => "\xc3\x83",  #Latin capital letter A with tilde
        '&Auml;'   => "\xc3\x84",  #Latin capital letter A with diaeresis
        '&Aring;'  => "\xc3\x85",  #Latin capital letter A with ring above = Latin capital letter A ring
        '&AElig;'  => "\xc3\x86",  #Latin capital letter AE = Latin capital ligature AE
        '&Ccedil;' => "\xc3\x87",  #Latin capital letter C with cedilla
        '&Egrave;' => "\xc3\x88",  #Latin capital letter E with grave
        '&Eacute;' => "\xc3\x89",  #Latin capital letter E with acute
        '&Ecirc;'  => "\xc3\x8a",  #Latin capital letter E with circumflex
        '&Euml;'   => "\xc3\x8b",  #Latin capital letter E with diaeresis
        '&Igrave;' => "\xc3\x8c",  #Latin capital letter I with grave
        '&Iacute;' => "\xc3\x8d",  #Latin capital letter I with acute
        '&Icirc;'  => "\xc3\x8e",  #Latin capital letter I with circumflex
        '&Iuml;'   => "\xc3\x8f",  #Latin capital letter I with diaeresis
        '&ETH;'    => "\xc3\x90",  #Latin capital letter ETH
        '&Ntilde;' => "\xc3\x91",  #Latin capital letter N with tilde
        '&Ograve;' => "\xc3\x92",  #Latin capital letter O with grave
        '&Oacute;' => "\xc3\x93",  #Latin capital letter O with acute
        '&Ocirc;'  => "\xc3\x94",  #Latin capital letter O with circumflex
        '&Otilde;' => "\xc3\x95",  #Latin capital letter O with tilde
        '&Ouml;'   => "\xc3\x96",  #Latin capital letter O with diaeresis
        '&times;'  => "\xc3\x97",  #multiplication sign
        '&Oslash;' => "\xc3\x98",  #Latin capital letter O with stroke = Latin capital letter O slash
        '&Ugrave;' => "\xc3\x99",  #Latin capital letter U with grave
        '&Uacute;' => "\xc3\x9a",  #Latin capital letter U with acute
        '&Ucirc;'  => "\xc3\x9b",  #Latin capital letter U with circumflex
        '&Uuml;'   => "\xc3\x9c",  #Latin capital letter U with diaeresis
        '&Yacute;' => "\xc3\x9d",  #Latin capital letter Y with acute
        '&THORN;'  => "\xc3\x9e",  #Latin capital letter THORN
      #Latin small letter
        '&szlig;'  => "\xc3\x9f",  #Latin small letter sharp s = ess-zed
        '&agrave;' => "\xc3\xa0",  #Latin small letter a with grave = Latin small letter a grave
        '&aacute;' => "\xc3\xa1",  #Latin small letter a with acute
        '&acirc;'  => "\xc3\xa2",  #Latin small letter a with circumflex
        '&atilde;' => "\xc3\xa3",  #Latin small letter a with tilde
        '&auml;'   => "\xc3\xa4",  #Latin small letter a with diaeresis
        '&aring;'  => "\xc3\xa5",  #Latin small letter a with ring above = Latin small letter a ring
        '&aelig;'  => "\xc3\xa6",  #Latin small letter ae = Latin small ligature ae
        '&ccedil;' => "\xc3\xa7",  #Latin small letter c with cedilla
        '&egrave;' => "\xc3\xa8",  #Latin small letter e with grave
        '&eacute;' => "\xc3\xa9",  #Latin small letter e with acute
        '&ecirc;'  => "\xc3\xaa",  #Latin small letter e with circumflex
        '&euml;'   => "\xc3\xab",  #Latin small letter e with diaeresis
        '&igrave;' => "\xc3\xac",  #Latin small letter i with grave
        '&iacute;' => "\xc3\xad",  #Latin small letter i with acute
        '&icirc;'  => "\xc3\xae",  #Latin small letter i with circumflex
        '&iuml;'   => "\xc3\xaf",  #Latin small letter i with diaeresis
        '&eth;'    => "\xc3\xb0",  #Latin small letter eth
        '&ntilde;' => "\xc3\xb1",  #Latin small letter n with tilde
        '&ograve;' => "\xc3\xb2",  #Latin small letter o with grave
        '&oacute;' => "\xc3\xb3",  #Latin small letter o with acute
        '&ocirc;'  => "\xc3\xb4",  #Latin small letter o with circumflex
        '&otilde;' => "\xc3\xb5",  #Latin small letter o with tilde
        '&ouml;'   => "\xc3\xb6",  #Latin small letter o with diaeresis
        '&divide;' => "\xc3\xb7",  #division sign
        '&oslash;' => "\xc3\xb8",  #Latin small letter o with stroke = Latin small letter o slash
        '&ugrave;' => "\xc3\xb9",  #Latin small letter u with grave
        '&uacute;' => "\xc3\xba",  #Latin small letter u with acute
        '&ucirc;'  => "\xc3\xbb",  #Latin small letter u with circumflex
        '&uuml;'   => "\xc3\xbc",  #Latin small letter u with diaeresis
        '&yacute;' => "\xc3\xbd",  #Latin small letter y with acute
        '&thorn;'  => "\xc3\xbe",  #Latin small letter thorn
        '&yuml;'   => "\xc3\xbf",  #Latin small letter y with diaeresis
      #Symbols and Greek Letters:
        '&fnof;'    => "\xc6\x92",  #Latin small f with hook = function = florin
        '&Alpha;'   => "\xce\x91",  #Greek capital letter alpha
        '&Beta;'    => "\xce\x92",  #Greek capital letter beta
        '&Gamma;'   => "\xce\x93",  #Greek capital letter gamma
        '&Delta;'   => "\xce\x94",  #Greek capital letter delta
        '&Epsilon;' => "\xce\x95",  #Greek capital letter epsilon
        '&Zeta;'    => "\xce\x96",  #Greek capital letter zeta
        '&Eta;'     => "\xce\x97",  #Greek capital letter eta
        '&Theta;'   => "\xce\x98",  #Greek capital letter theta
        '&Iota;'    => "\xce\x99",  #Greek capital letter iota
        '&Kappa;'   => "\xce\x9a",  #Greek capital letter kappa
        '&Lambda;'  => "\xce\x9b",  #Greek capital letter lambda
        '&Mu;'      => "\xce\x9c",  #Greek capital letter mu
        '&Nu;'      => "\xce\x9d",  #Greek capital letter nu
        '&Xi;'      => "\xce\x9e",  #Greek capital letter xi
        '&Omicron;' => "\xce\x9f",  #Greek capital letter omicron
        '&Pi;'      => "\xce\xa0",  #Greek capital letter pi
        '&Rho;'     => "\xce\xa1",  #Greek capital letter rho
        '&Sigma;'   => "\xce\xa3",  #Greek capital letter sigma
        '&Tau;'     => "\xce\xa4",  #Greek capital letter tau
        '&Upsilon;' => "\xce\xa5",  #Greek capital letter upsilon
        '&Phi;'     => "\xce\xa6",  #Greek capital letter phi
        '&Chi;'     => "\xce\xa7",  #Greek capital letter chi
        '&Psi;'     => "\xce\xa8",  #Greek capital letter psi
        '&Omega;'   => "\xce\xa9",  #Greek capital letter omega
        '&alpha;'   => "\xce\xb1",  #Greek small letter alpha
        '&beta;'    => "\xce\xb2",  #Greek small letter beta
        '&gamma;'   => "\xce\xb3",  #Greek small letter gamma
        '&delta;'   => "\xce\xb4",  #Greek small letter delta
        '&epsilon;' => "\xce\xb5",  #Greek small letter epsilon
        '&zeta;'    => "\xce\xb6",  #Greek small letter zeta
        '&eta;'     => "\xce\xb7",  #Greek small letter eta
        '&theta;'   => "\xce\xb8",  #Greek small letter theta
        '&iota;'    => "\xce\xb9",  #Greek small letter iota
        '&kappa;'   => "\xce\xba",  #Greek small letter kappa
        '&lambda;'  => "\xce\xbb",  #Greek small letter lambda
        '&mu;'      => "\xce\xbc",  #Greek small letter mu
        '&nu;'      => "\xce\xbd",  #Greek small letter nu
        '&xi;'      => "\xce\xbe",  #Greek small letter xi
        '&omicron;' => "\xce\xbf",  #Greek small letter omicron
        '&pi;'      => "\xcf\x80",  #Greek small letter pi
        '&rho;'     => "\xcf\x81",  #Greek small letter rho
        '&sigmaf;'  => "\xcf\x82",  #Greek small letter final sigma
        '&sigma;'   => "\xcf\x83",  #Greek small letter sigma
        '&tau;'     => "\xcf\x84",  #Greek small letter tau
        '&upsilon;' => "\xcf\x85",  #Greek small letter upsilon
        '&phi;'     => "\xcf\x86",  #Greek small letter phi
        '&chi;'     => "\xcf\x87",  #Greek small letter chi
        '&psi;'     => "\xcf\x88",  #Greek small letter psi
        '&omega;'   => "\xcf\x89",  #Greek small letter omega
        '&thetasym;'=> "\xcf\x91",  #Greek small letter theta symbol
        '&upsih;'   => "\xcf\x92",  #Greek upsilon with hook symbol
        '&piv;'     => "\xcf\x96",  #Greek pi symbol

        '&bull;'    => "\xe2\x80\xa2",  #bullet = black small circle
        '&hellip;'  => "\xe2\x80\xa6",  #horizontal ellipsis = three dot leader
        '&prime;'   => "\xe2\x80\xb2",  #prime = minutes = feet (��� ����������� ����� � �����)
        '&Prime;'   => "\xe2\x80\xb3",  #double prime = seconds = inches (��� ����������� ������ � ������).
        '&oline;'   => "\xe2\x80\xbe",  #overline = spacing overscore
        '&frasl;'   => "\xe2\x81\x84",  #fraction slash
        '&weierp;'  => "\xe2\x84\x98",  #script capital P = power set = Weierstrass p
        '&image;'   => "\xe2\x84\x91",  #blackletter capital I = imaginary part
        '&real;'    => "\xe2\x84\x9c",  #blackletter capital R = real part symbol
        '&trade;'   => "\xe2\x84\xa2",  #trade mark sign
        '&alefsym;' => "\xe2\x84\xb5",  #alef symbol = first transfinite cardinal
        '&larr;'    => "\xe2\x86\x90",  #leftwards arrow
        '&uarr;'    => "\xe2\x86\x91",  #upwards arrow
        '&rarr;'    => "\xe2\x86\x92",  #rightwards arrow
        '&darr;'    => "\xe2\x86\x93",  #downwards arrow
        '&harr;'    => "\xe2\x86\x94",  #left right arrow
        '&crarr;'   => "\xe2\x86\xb5",  #downwards arrow with corner leftwards = carriage return
        '&lArr;'    => "\xe2\x87\x90",  #leftwards double arrow
        '&uArr;'    => "\xe2\x87\x91",  #upwards double arrow
        '&rArr;'    => "\xe2\x87\x92",  #rightwards double arrow
        '&dArr;'    => "\xe2\x87\x93",  #downwards double arrow
        '&hArr;'    => "\xe2\x87\x94",  #left right double arrow
        '&forall;'  => "\xe2\x88\x80",  #for all
        '&part;'    => "\xe2\x88\x82",  #partial differential
        '&exist;'   => "\xe2\x88\x83",  #there exists
        '&empty;'   => "\xe2\x88\x85",  #empty set = null set = diameter
        '&nabla;'   => "\xe2\x88\x87",  #nabla = backward difference
        '&isin;'    => "\xe2\x88\x88",  #element of
        '&notin;'   => "\xe2\x88\x89",  #not an element of
        '&ni;'      => "\xe2\x88\x8b",  #contains as member
        '&prod;'    => "\xe2\x88\x8f",  #n-ary product = product sign
        '&sum;'     => "\xe2\x88\x91",  #n-ary sumation
        '&minus;'   => "\xe2\x88\x92",  #minus sign
        '&lowast;'  => "\xe2\x88\x97",  #asterisk operator
        '&radic;'   => "\xe2\x88\x9a",  #square root = radical sign
        '&prop;'    => "\xe2\x88\x9d",  #proportional to
        '&infin;'   => "\xe2\x88\x9e",  #infinity
        '&ang;'     => "\xe2\x88\xa0",  #angle
        '&and;'     => "\xe2\x88\xa7",  #logical and = wedge
        '&or;'      => "\xe2\x88\xa8",  #logical or = vee
        '&cap;'     => "\xe2\x88\xa9",  #intersection = cap
        '&cup;'     => "\xe2\x88\xaa",  #union = cup
        '&int;'     => "\xe2\x88\xab",  #integral
        '&there4;'  => "\xe2\x88\xb4",  #therefore
        '&sim;'     => "\xe2\x88\xbc",  #tilde operator = varies with = similar to
        '&cong;'    => "\xe2\x89\x85",  #approximately equal to
        '&asymp;'   => "\xe2\x89\x88",  #almost equal to = asymptotic to
        '&ne;'      => "\xe2\x89\xa0",  #not equal to
        '&equiv;'   => "\xe2\x89\xa1",  #identical to
        '&le;'      => "\xe2\x89\xa4",  #less-than or equal to
        '&ge;'      => "\xe2\x89\xa5",  #greater-than or equal to
        '&sub;'     => "\xe2\x8a\x82",  #subset of
        '&sup;'     => "\xe2\x8a\x83",  #superset of
        '&nsub;'    => "\xe2\x8a\x84",  #not a subset of
        '&sube;'    => "\xe2\x8a\x86",  #subset of or equal to
        '&supe;'    => "\xe2\x8a\x87",  #superset of or equal to
        '&oplus;'   => "\xe2\x8a\x95",  #circled plus = direct sum
        '&otimes;'  => "\xe2\x8a\x97",  #circled times = vector product
        '&perp;'    => "\xe2\x8a\xa5",  #up tack = orthogonal to = perpendicular
        '&sdot;'    => "\xe2\x8b\x85",  #dot operator
        '&lceil;'   => "\xe2\x8c\x88",  #left ceiling = APL upstile
        '&rceil;'   => "\xe2\x8c\x89",  #right ceiling
        '&lfloor;'  => "\xe2\x8c\x8a",  #left floor = APL downstile
        '&rfloor;'  => "\xe2\x8c\x8b",  #right floor
        '&lang;'    => "\xe2\x8c\xa9",  #left-pointing angle bracket = bra
        '&rang;'    => "\xe2\x8c\xaa",  #right-pointing angle bracket = ket
        '&loz;'     => "\xe2\x97\x8a",  #lozenge
        '&spades;'  => "\xe2\x99\xa0",  #black spade suit
        '&clubs;'   => "\xe2\x99\xa3",  #black club suit = shamrock
        '&hearts;'  => "\xe2\x99\xa5",  #black heart suit = valentine
        '&diams;'   => "\xe2\x99\xa6",  #black diamond suit
      #Other Special Characters:
        '&OElig;'  => "\xc5\x92",  #Latin capital ligature OE
        '&oelig;'  => "\xc5\x93",  #Latin small ligature oe
        '&Scaron;' => "\xc5\xa0",  #Latin capital letter S with caron
        '&scaron;' => "\xc5\xa1",  #Latin small letter s with caron
        '&Yuml;'   => "\xc5\xb8",  #Latin capital letter Y with diaeresis
        '&circ;'   => "\xcb\x86",  #modifier letter circumflex accent
        '&tilde;'  => "\xcb\x9c",  #small tilde
        '&ensp;'   => "\xe2\x80\x82",  #en space
        '&emsp;'   => "\xe2\x80\x83",  #em space
        '&thinsp;' => "\xe2\x80\x89",  #thin space
        '&zwnj;'   => "\xe2\x80\x8c",  #zero width non-joiner
        '&zwj;'    => "\xe2\x80\x8d",  #zero width joiner
        '&lrm;'    => "\xe2\x80\x8e",  #left-to-right mark
        '&rlm;'    => "\xe2\x80\x8f",  #right-to-left mark
        '&ndash;'  => "\xe2\x80\x93",  #en dash
        '&mdash;'  => "\xe2\x80\x94",  #em dash
        '&lsquo;'  => "\xe2\x80\x98",  #left single quotation mark
        '&rsquo;'  => "\xe2\x80\x99",  #right single quotation mark (and apostrophe!)
        '&sbquo;'  => "\xe2\x80\x9a",  #single low-9 quotation mark
        '&ldquo;'  => "\xe2\x80\x9c",  #left double quotation mark
        '&rdquo;'  => "\xe2\x80\x9d",  #right double quotation mark
        '&bdquo;'  => "\xe2\x80\x9e",  #double low-9 quotation mark
        '&dagger;' => "\xe2\x80\xa0",  #dagger
        '&Dagger;' => "\xe2\x80\xa1",  #double dagger
        '&permil;' => "\xe2\x80\xb0",  #per mille sign
        '&lsaquo;' => "\xe2\x80\xb9",  #single left-pointing angle quotation mark
        '&rsaquo;' => "\xe2\x80\xba",  #single right-pointing angle quotation mark
        '&euro;'   => "\xe2\x82\xac",  #euro sign
    );
    $htmlspecialchars = array(
        '&quot;' => "\x22",  #quotation mark = APL quote (") &#34;
        '&amp;'  => "\x26",  #ampersand                  (&) &#38;
        '&lt;'   => "\x3c",  #less-than sign             (<) &#60;
        '&gt;'   => "\x3e",  #greater-than sign          (>) &#62;
    );

    if ($is_htmlspecialchars)
    {
        $table += $htmlspecialchars;
    }

    #�������� ����������� ��������:
    #����������� ��������: �������� ������ �� ��������, ������� ������������ � html ����!
    preg_match_all('/&[a-zA-Z]+\d*;/s', $s, $m);
    foreach (array_unique($m[0]) as $entity)
    {
        if (array_key_exists($entity, $table))
        {
            $s = str_replace($entity, $table[$entity], $s);
        }
    }#foreach

    #�������� �������� dec � hex ��������:
    $htmlspecialchars_flip = array_flip($htmlspecialchars);

    $s = preg_replace(
        '/&#((x)[\da-fA-F]{2,4}|\d{1,4});/se',
        '(isset($htmlspecialchars_flip[$a = pack("C", $d = ("$2") ? hexdec("$1") : "$1")]) && ! $is_htmlspecialchars) ?
         $htmlspecialchars_flip[$a] :
         iconv("UCS-2BE", "UTF-8", pack("n", $d))',
        $s);
    return $s;
   }
   
   
   
   static function stripHTML($document)
   {   
    $search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезается javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Вырезаются html-тэги
                 "'([\r\n])[\s]+'",                 // Вырезается пустое пространство
                 "'&(quot|#34);'i",                 // Замещаются html-элементы
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i","'&(gt|#62);'i","'&(nbsp|#160);'i","'&(iexcl|#161);'i",
                 "'&(cent|#162);'i","'&(pound|#163);'i","'&(copy|#169);'i","'&#(\d+);'e");                 

	   $replace = array ("","","\\1","\"","&","<",">"," ",chr(161),chr(162),chr(163),chr(169),"chr(\\1)");
	   $text = preg_replace ($search, $replace, $document);
	   return $text;
   }
   
   // 
   static function removeTags($content,$nl2br=null)
   {
   	  $content = strip_tags($content,"<p><b><i><br><strong><a><li><ul><ol>");   	  
   	  if(!$nl2br)
   	  	return nl2br($content);
   	  else
   	    return $content;	
   }
}
?>
