<?php
class Socnet_Image_Captcha
{
    public function __construct()
    {
    }

    public static function generateCaptcha(&$code)
    {
        srand(time());
        $code   = ($code === null) ? rand(1000,9999) : $code;
        $i      = rand(1,2);
        $im     = DOC_ROOT."/upload/imgkey/fon$i.png";
        $im     = ImageCreateFromPNG($im);
        $code   = strval($code);

        for ($i = 1; $i <= strlen($code); $i++) {
            $color = ImageColorAllocate($im, rand(0, 150),
            rand(0, 150), rand(0, 150));
            ImageString($im, rand(4,15), 20*$i-rand(0,10),
            rand(10,30), $code{$i-1}, $color);
        }

        ImagePng($im, DOC_ROOT."/upload/imgkey/".md5($code).".png");
        ImageDestroy($im);
        return "<img src='/upload/imgkey/".md5($code).".png"."'>";
    }
}
?>