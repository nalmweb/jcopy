<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
			<title>MotoFriends.ru – нужен каждому мотоциклисту</title>
			
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	{$XajaxJavascript}
	{literal}
	<style type="text/css">
	BODY {
	background-color: black;
	margin: 0;
	padding: 0;
	color: white;
	height: 100%;
	}
	
	table {
	background-repeat: no-repeat;
	background-position: 0px 0px;
	background-image: url(/images/inv/bg.jpg);
	font-size: 150%;
	font-family: Helvetica, Verdana, Arial, sans-serif;
	}
	.input-text {
		font-size: 100%;
		height: 28px;
		border-color: #333333;
		color: white;
		background-color: black;
	}	
	#nick{
		background: no-repeat scroll left center;
	    width: 454px;
	}	
	#input-button {
		border-color: #333333;
		color: white;
		background-color: #191919;
		font-size: 50%;
	}
	
	
	#submit  {
		border-color: #333333;
		color: white;
		background-color: #191919;
		font-size: 50%;
	}
	#submit2
	  {
		border-color: #333333;
		color: white;
		background-color: #191919;
		font-size: 50%;
	}
	.select-bike {
		border-color: #333333;
		color: white;
		background-color: black;
	}
	
	#select-bike 
	{
	   border:solid 0px #555;
	   width:500px;
	}
	
	.frm-invite {
		padding-right: 50px;
		text-align: right;
	}
	
	p {
		text-shadow: 2px 2px 2px black;
		margin-bottom: 5px;
		text-align: left;
	}
	
	#frm-log-in {
		padding-right: 50px;
		text-align: right;
	}
	
	#link-btn {
		color: #993333;
		font-size: 70%;
	}
	.link-small {
		padding-right: 10px;
		color: #993333;
		font-size: 60%;
	}
	
	.png { behavior: url(/images/inv/iepngfix.htc); }
	#promo {
		
		border-color: black;
		border-width: 1px;
		border-style: solid;
		background-color: black;
		height: 400px;
		width: 640px;
	}
	
	</style>

<script type="text/javascript">
	
	function showpromo()
    {
        document.getElementById('promo').style.display = 'block';
    }

	function hidepromo()
    {
        document.getElementById('promo').style.display = 'none';
    }

	function enable(id)
	{
		var elem = document.getElementById(id);
		document.forms[0].submit.disabled = false;
	}
	
    function custombikeshow()
    {
        document.getElementById('select-bike').style.display = 'none';
        document.getElementById('custom-bike').style.display = 'block';
    }
    
    function custombikehide()
    {
        document.getElementById('select-bike').style.display = 'block';
        document.getElementById('custom-bike').style.display = 'none';
    }
    function loginformshow()
    {
        document.getElementById('frm-invite').style.display = 'none';
        document.getElementById('frm-log-in').style.display = 'block';
    }
    
    function loginformhide()
    {
        document.getElementById('frm-invite').style.display = 'block';
        document.getElementById('frm-log-in').style.display = 'none';
    }
    
    
    function changeBike()
    {
       document.getElementById('nick').style.backgroundImage = "url(/images/helmets/chopper.gif)";
       document.getElementById('nick').style.background = "background-repeat:no";
    }
    
    function setStatus(status){
     
        if(status=='ok')
        {
          document.getElementById('nick').style.backgroundImage = "url(/images/helmets/chopper.gif)";
          document.getElementById('nick').style.background = "background-repeat:no";
        }
        else
        {
        
        }
    }
    
    function onChangeYear()
    {    
    	var elem = document.getElementById('yearId');
	    var option =  elem.options[elem.selectedIndex];
	    var value = option.text;
	    var year = document.getElementById('year');
	    year.value=value;
	    xajax_changeTrademarkOnInvite(xajax.getFormValues('frm-invite'));
    }
    //
    function checkNickname ()
    {
       var nick = document.getElementById('nick').value;
       nick = trimString(nick);
              
       if(nick!='' && nick!='ник')
       { 
         xajax_checkNickname(nick);
       }
       else 
       {
         alert("Введите Ник!");
       	 return false;
       }
    }   
     
	//  onkeyup = setTimeout("init('email')",1000)
    
    function validate_email()
	{
		elem = document.getElementById('email');
		if( elem.value.indexOf('@') < 0  ||  elem.value.indexOf('.') < 0 ){
		   return false;
		}
		return true;
	}
	
   function checkPassword(id)
   {

	 var pass = document.getElementById(id);
	 var pass_value = pass.value;
	 pass_value = trimString(pass_value);
	 
	 if(pass_value!='')
	 	 return true;
	 return false;
   }

   function checkPass(param)
   {
    var pass1=document.getElementById('pass1').value;
    var pass2=document.getElementById('pass2').value;
    var elem = document.getElementById('load_'+param);    
    var img = document.createElement('img');
    
    pass1=pass1.replace(/ +$/,""); 
    pass1=pass1.replace(/^ +/,"");
    
    pass2=pass2.replace(/ +$/,""); 
    pass2=pass2.replace(/^ +/,"");
    
     //if(pass1.)
     if(pass1.length <= 5 )
     {
        //alert("Password must be at least 6 letters long");
        elem.innerHTML = " Password must be at least 6 letters long ";
        img.src="/images/cancel.png";
     }
     else if(pass1!=pass2){
        elem.innerHTML ="passwords don't match!";
        img.src="/images/cancel.png";
     }
    
     else
     {
        elem.innerHTML="";
        img.src="/images/accept.png";
        var e = document.getElementById('email');
        e.disabled=false;
     }
     
     elem.appendChild(img);
     elem.style.display="block";
    }
  
   // return: trimmed string on both sides.
   function trimString(str)
   {
     str=str.replace(/ +$/,""); 
     str=str.replace(/^ +/,"");
     
     return str;
   }
   
  function clear(param)
  {
    var elem = document.getElementById('load_'+param); 
    elem.innerHTML = '';
    elem = document.getElementById(param).value=""; 
  }
  
  // 
  function resetValue(elem_id,value)
  {    
     var elem = document.getElementById(elem_id);
     elem.value='';
  }
  
  function setValue(elem_id,value){
     var elem = document.getElementById(elem_id);
     if(elem.value=='') elem.value=value;
  }
</script>
 {/literal}
	</head>
	<body>
	<br /><br /><br /><br />
	<center>
	<div id="promo" style="display: none;">
	<div align="right" style="font-family: Helvetica, Verdana, Arial, sans-serif;"><span style="font-size: 12px; color: #444444;"><a href="/images/promo/motofriends-video.mov.zip" style="font-size: 12px; color: #444444;" onClick="javascript:pageTracker._trackPageview('/G3/promo/motofriends-video.mov.zip');">скачать это видео</a> | <a href="#null" onclick="hidepromo(); return false;" style="font-size: 12px; color: #444444;">закрыть<img align="absmiddle" src="/images/promo/close_view.gif" border="0"></a></span>
	</div>
	<script src="/images/promo/Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/javascript">
	AC_FL_RunContent ( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','640','height','360','id','FLVPlayer','src','FLVPlayer_Progressive','flashvars','&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=images/promo/promo&autoPlay=false&autoRewind=false','quality','high','scale','noscale','name','FLVPlayer','salign','lt','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','FLVPlayer_Progressive' ); //end AC code
	</script>
	<noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="640" height="360" id="FLVPlayer">
	  <param name="movie" value="FLVPlayer_Progressive.swf" />
	  <param name="salign" value="lt" />
	  <param name="quality" value="high" />
	  <param name="scale" value="noscale" />
	  <param name="FlashVars" value="&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=images/promo/promo&autoPlay=false&autoRewind=false" />
	  <embed src="FLVPlayer_Progressive.swf" flashvars="&MM_ComponentVersion=1&skinName=Clear_Skin_1&streamName=images/promo/promo&autoPlay=false&autoRewind=false" quality="high" scale="noscale" width="640" height="360" name="FLVPlayer" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" />
	</object></noscript>
	</div>
</center>
	<br /><br />
	<center>
	  <table id="table-content" height="282px" width="772px" border="0">
	    <tr>
		  <td align="right" valign="top" ><img class="png" src="/images/inv/logo.png" width="243px" height="140px"></td>
			<td align="left">
			<!--<form id="frm-invite" class="frm-invite" method="POST" action="/index/invite/"> -->
			{if $formContent.errors}
			   {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}
			{/if}
			<p>{$message}</p>
			  <form {$formContent.attributes} class="frm-invite" onsubmit="checkPassword('password');" >
			  	{$formContent.hidden}
			  	<input type="hidden" name="year" id="year" value"" >
				<p>Cкоро открытие сайта, нужного каждому мотоциклисту. Выбери свой байк, введи ник, пароль и почтовый адрес* – и мы скоро вышлем тебе приглашение. <a style="font-size: 14px; color: #FF6600" href="#null" onclick="showpromo(); return false; javascript:pageTracker._trackPageview('/G2/showpromovideo');">зачем мне это?</a> <a href="#null" onclick="showpromo(); return false; javascript:pageTracker._trackPageview('/G2/showpromovideo');"><img align="absmiddle" class="png" src="/images/promo/player_play.png" border="0"></a></p>
				<div id="custom-bike" style="display:none; height: 50px;">
					{literal}
				<input style="width: 454px;" class="input-text" type="text" value="Производитель, модель, год" onfocus="if(this.value=='Производитель, модель, год'){this.value='';}" onblur="if(this.value=='' ){this.value='Производитель, модель, год';}" name="custom_bike"/>
					{/literal}
				<br />
				<nobr><a class="link-small" href="#null" onclick="custombikehide(); return false;">вернуться к выбору</a></nobr>
				</div>
				<div id="select-bike" style="height:50px;">
				{$formContent.markId.html}
				{$formContent.modelId.html}
				{$formContent.yearId.html}
				<br />
				<a class="link-small" href="#null" onclick="custombikeshow(); return false;">не нашел модель?</a><br />
				</div>
			 	<div>
				<div id="status" style="border:solid 0px #fff;float: left; width: 15px; height: 15px;">&nbsp;</div>
				
				{$formContent.nick.html}
		{literal}
				
		{/literal}
			    </div>
				<div>
				{$formContent.password.html}

			</div>
			<div>
			  {$formContent.email.html}
  			 {literal}
  			 {/literal}
	      	</div>
	<br />
			<div>
				<span style="font-size:14px;">
					Если при выборе ника вы видете - <img align="absmiddle" class="png" src="/images/cancel.png">, значит такой ник уже занят
					<br />
					<sup>*</sup>все поля обязательны для заполнения</span>
			</div>
			<div align="right">
				<nobr><a id="link-btn" href="#null" onclick="loginformshow(); return false;">я счастливчик</a></nobr>
				<input id="submit" type="submit" value="Пришлите скорее" name="get_inv" class="button" />
			 </div>
			</form>
			<form action="/invite/login/" method="post" name="loginForm" id="frm-log-in" style="display:none;" onsubmit="checkPassword('password2');">
			  <p>Есть пароль для входа? Значит тебе очень повезло ;)</p>
			  {literal}
			  <input style="width: 180px;" class="input-text" type="text" value="E-mail" name="login" id="email2"
			     	 onfocus="resetValue(this.id,'E-mail');" onblur="setValue(this.id,'E-mail');" />
			  {/literal}
			  <input style="width: 180px;" class="input-text" type="password" value="pass" name="password" id="password2"
			  		onfocus="resetValue(this.id,'pass');" /><br />
			  <div align="right"><a id="link-btn" href="#null" onclick="loginformhide(); return false;">хочу приглашение</a>
		        <input id="submit2" type="submit" value="Войти" name="log-in" class="button" />
		     </div>
		  </form>
		</td>
	  </tr>
    </table>
  </center>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3722543-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
<!-- YaMetrics begin -->
<script type="text/javascript"><!--
var ya_cid=78672;
//--></script>
<script src="http://bs.yandex.ru/resource/watch.js" type="text/javascript"></script>
<noscript><div style="display: inline;"><img src="http://bs.yandex.ru/watch/78672" width="1" height="1" alt=""></div></noscript>
<!-- YaMetrics end -->
 </body>
</html>