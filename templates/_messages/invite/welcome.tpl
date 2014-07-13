{capture name="_from_"}
    "Регистрация на 'Мото Друзьях'" <motorobot@motofriends.ru>
{/capture}

{capture name="_subject_"}
   Приглашение на www.motofriends.ru 
{/capture}


{capture name="_mail_html_part_" }
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor='#000000'>
<STYLE>
 .headerTop { background-color:#66CC00; border-top:0px solid #000000; border-bottom:0px solid #FFCC66; text-align:right; }
 .adminText { font-size:10px; color:#FFFFCC; line-height:200%; font-family:verdana; text-decoration:none; }
 .headerBar { background-color:#FFFFFF; border-top:0px solid #FFFFFF; border-bottom:0px solid #333333; }
 .title { font-size:22px; font-weight:bold; color:#336600; font-family:arial; line-height:110%; }
 .subTitle { font-size:11px; font-weight:normal; color:#666666; font-style:italic; font-family:arial; }
 td { font-size:14px; color:#000000; line-height:150%; font-family:trebuchet ms; }
 .footerRow { background-color:#FFFFCC; border-top:10px solid #FFFFFF; }
 .footerText { font-size:10px; color:#333333; line-height:100%; font-family:verdana; }
 a { color:#FF0000; color:#FF6600; color:#FF6600; }
 h1 { line-height:100%; }
</STYLE>

<table width="100%" cellpadding="10" cellspacing="0" class="backgroundTable" bgcolor='#000000' >
<tr>
<td valign="top" align="center">
<table width="800" cellpadding="0" cellspacing="0">
<tr>
<td style="background-color:#000000;border-top:0px solid #FFFFFF;border-bottom:0px solid #333333;"><center><img src="head_img.jpg" width="600" height="228" border="0" alt="Мото-друг, давай к нам!"></center></td>
</tr>
</table>

<table width="600" cellpadding="20" cellspacing="0" bgcolor="#000000">
<tr>
<td bgcolor="#000000" valign="top" style="font-size:14px;color:#000000;line-height:150%;font-family:trebuchet ms;">

<p>
<h1><font color="#FFFFFF" face="Arial">Привет, {$recepient->nikname}!</font></h1>

<font color="#FFFFFF" face="Arial">
По многочисленным просьбам мы открываемся раньше запланированного. Впереди вас ждет масса интересных изменений. А сейчас прочитайте, пожалуйста, все что ниже. Если заметите ошибки на сайте, просим сообщать об этом по адресу <a href="mailto:support@motofriends.ru">support@motofriends.ru</a>
</font>
</p>

<center>
<table width="100%" border="1" cellpadding="10" bordercolor="#FF9900" bgcolor="#FFFF99">
<tr>
<td><b><font color="#000000" face="Arial">Для активации своего аккаунта, пройдите <u><a href="http://motofriends.ru/registration/index/code/{$recipient->registerCode}/" target="_blank">сюда</a></u></b>
<br/><br/>
Логин: <b>{$recepient->login}</b>
<br/>
Пароль: <b>{$recepient->pass}</b>
</font>
<br /><br />
<b><font color="red" face="Arial">ВНИМАНИЕ!</font></b> <font color="#000000"  face="Arial">В следующий раз, когда захотите войти на сайт, нажмите "я счастливчик" (на главной странице) и введите e-mail в качестве логина и пароль.</font>

</td>
</tr>
</table>
</center>

<br><br>
<center>
<img src="hr.gif" width="502" height="1">
</center>
<p>
<h1><font color="red" face="Arial">Создавай встречи!</font></h1>
<font color="#FFFFFF" face="Arial">
Сезон мото-встреч на носу!<br>Никогда еще не было такого простого способа создания встреч! <a href="http://motofriends.ru/meetings/">Организуй встречу</a> или поездку за город на мотоциклах, указав место на карте и назначив дату сбора. Нет ничего лучше, чем встретиться с друзьями-единомышленниками и пообщаться на общую для всех тему.<br />
Даже если вы новичок и никого не знаете, не расстраивайтесь – создайте встречу и к вам присоединяться десятки единомышленников.
</font>
<br>
<div style="width:100%">
<h1><font color="red" face="Arial">Специализированная доска объявлений</font></h1>
</div>

<font color="#FFFFFF" face="Arial">
Кроме того, мы создали для вас <a href="http://motofriends.ru/board/">первую специлизированную доску объявлений</a> по продаже мототехники, экипировки, запчастей и аксессуаров. Алгоритмы настроены таким образом, что покупатель объявится в максимально короткие сроки.
</font>

<br>
<h1><font color="red" face="Arial">А так же</font></h1>

<font color="#FFFFFF" face="Arial">
<ul>
<li>вы будете максимально информированы о том что творится в мире мото, и сами сможете публиковать интересную информацию, которые увидят все</li>
<li>мотоцикл - это свобода! Также и у нас - в вашем распоряжении удобный фотоальбом с <b>неограниченным местом</b> под фотографии</li>
<li>приятная аудитория для общения</li>
<li>и многое другое... а что именно, вы узнаете скоро ;)</li>
</ul>
</font>
</p>

<center>
<a href="http://motofriends.ru/registration/index/code/{$recipient->registerCode}/"><img src="enter.gif" border="0" weight="214" height="49"></a><br><br>
<img src="hr.gif" width="502" height="1">
</center>
</td>
</tr>


<tr>
<td style="background-color:#000000;border-top:10px solid #000000;" valign="top">
<span style="font-size:10px;line-height:100%;font-family:verdana;"><font color="#333333" face="Arial">
<center>
Мы строго соблюдаем политику конфиденциальности. Данные, которые Вы предоставили никогда не будут переданы третьим лицам и использованы для рассылки рекламы.
<br>
По всем вопросам обращаться по адресу <a href="mailto:support@motofriends.ru">support@motofriends.ru</a>
<br><br>
<a href="http://motofriends.ru/"><img src="motofriends_logo_small.gif" border="0" width="100" height="53"></a><br><br>
<small>&copy; 2008</small>
</center>
</font>
</span>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
{/capture}