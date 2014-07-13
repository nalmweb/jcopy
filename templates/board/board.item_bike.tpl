{literal}
<script language="JavaScript">
<!-- Original:  Jenny Blewitt (webmaster@webdesignsdirect.com)-->
<!-- Web Site:  http://www.webdesignsdirect.com 		   -->
<!-- This script and many more are available free online at-->
<!-- The JavaScript Source!! http://javascript.internet.com-->
<!-- Begin
browserName = navigator.appName;
browserVer = parseInt(navigator.appVersion);

ns3up = (browserName == "Netscape" && browserVer >= 3);
ie4up = (browserName.indexOf("Microsoft") >= 0 && browserVer >= 4);

function doPic(imgName) {
if (ns3up || ie4up) {
imgOn = ("" + imgName);
document.mainpic.src = imgOn;
  }
}
//End -->
</script>
{/literal}
{assign var=mark  value=$ad->getMark()}
{assign var=model value=$ad->getModel()}
<h1><a href="/">{$crumbs[0]}</a> / <a href="/board/">{$crumbs[1]}</a> / <a href="/board/listauto/">Легковые автомобили</a> /
<a href="/board/listauto/trademark/{$mark}">{$mark}</a> / <a href="/board/listauto/trademark/{$mark}/model/{$model}">{$model}</a></h1>

<h1>Объявление: <a href="/board/item/auto/{$ad->getId()}.html">{$ad->title}</a> &nbsp; {*if $isOwner}[<a href="/users/adsEdit/cat/{$ad->getCatId()}/item/{$ad->getId()}/">Редактировать</a>]{/if}*}</h1>

<table width="60%" border="0" style="border-style: solid; border-width: 1px; border-color: #c7d9d6; text-align: left;">
 <tbody>
  <tr style="background-color: #ebebeb;">
	<td><strong>Модификация:</strong></td>
	<td>{$ad->getBikeType()}</td>
	<td><strong>Пробег:</strong></td>
	<td>{$ad->getProbeg()} км</td>
  </tr>
  <tr style="background-color: #cccccc;">
   	<td><strong>Год выпуска:</strong></td>
	<td>{$ad->getYear()}</td>
   	<td><strong>Состояние:</strong></td>
	<td>{$ad->getCondition()}</td>		
  </tr>
  <tr style="background-color: #ebebeb;">
    <td><strong>Объем двигателя:</strong></td>
	<td>{$ad->getVolume()} см<sup>3</sup></td>
    <td><strong>Место продажи:</strong></td>
	<td>{if $ad->getCity()} {$ad->getCity()->getCountry()->name|escape:html}, {$ad->getCity()->name|escape:html}{else}Не указано{/if}</td>
  </tr>
  <tr style="background-color: #cccccc;">
    <td><strong>Мощность:</strong></td>
	<td>{$ad->getPower()} л.с.</td>
    <td><strong>Торг возможен:</strong></td>
	<td>{if $ad->getTorg()}Да{else}Нет{/if}</td>
  </tr>
  <tr style="background-color: #ebebeb;">
    <td><strong>КПП:</strong></td>
	<td>{$ad->getKPP()}</td>
	<td><strong>Цена:</strong></td>
	<td>{$ad->getPrice()}</td>
  </tr>
</tbody>
</table>
{*
{if !empty($ad->mark_id)} 
   <div align="right"><a href="/catalog/trademark/id/{$ad->mark_id}/">смотреть все характеристики для {$mark} {$model} в каталоге </a></div>
{/if}
*}

<table width="60%" border="0">
	<tbody>
		<tr>
			<td>
				<!-- Widget start -->
				{literal}
				<script type="text/javascript">
				function highlight(field) {
				        field.focus();
				        field.select();
				}
				function showhtml()
				{
					document.getElementById('board-badge-html').style.display = 'block';
					document.getElementById('board-badge-bb').style.display = 'none';
					document.getElementById('board-badge-httplink').style.display = 'none';
				}
				function showbb()
				{
					document.getElementById('board-badge-html').style.display = 'none';
					document.getElementById('board-badge-bb').style.display = 'block';
					document.getElementById('board-badge-httplink').style.display = 'none';
				}
				function showurl()
				{
					document.getElementById('board-badge-html').style.display = 'none';
					document.getElementById('board-badge-bb').style.display = 'none';
					document.getElementById('board-badge-httplink').style.display = 'block';
				}
				</script>
				{/literal}

				Получить код: <a onclick="showhtml(); return false;" href="#null"><img src="/images/userinfo.gif" align="absmiddle" border="0">HTML</a> <a onclick="showbb(); return false;" href="#null">BB-code</a> <a onclick="showurl(); return false;" href="#null">URL</a>
				<br>

				<div id="board-badge-html" style="display: none; width: 300px;">
				<span>скопируйте этот код и используйте для вставки в свой блог, ЖЖ или на любой другой сайт</span><br>
				<textarea onclick="highlight(this)" style="overflow: hidden; width: 300px; height: 70px;" size="70">
<div style="width: 500px; color: black; background-color: #fcfcfc; border-width: 1px; border-style: outset;">
<table border="0" cellpadding="10" style="font-size: 12px; font-family: Verdana, Arial, sans-serif; line-height: 15px;">
<tr>
<td width="368"><h1 style="line-height: 1;">{$ad->title}</h1></td>
</tr>
<tr>
<td>{if !empty($photos)}<center><a href="{$self}"><img src="http://{$BASE_HTTP_HOST}{$photos[0].small}" width="128" height="84" border="0" /></a><br>
<a href="{$self}">все фото</a></center>{/if}</td>
<td><p>{$ad->content} <a href="{$self}">подробнее &rarr;</a></p>
<p>Модель: <a href="{$self}">{$mark} {$model} {$ad->getYear()}</a><br />
Пробег: <strong>{$ad->getProbeg()} км</strong><br />
Город: <strong>{if $ad->getCity()} {$ad->getCity()->name|escape:html} ({$ad->getCity()->getCountry()->name|escape:html}){else}Не указано{/if}</strong><br />
<span style="color: #FF0000;">Цена: <strong>{$ad->getPrice()} руб</strong></span><br />
Торг: <b>{if $ad->getTorg()}Да{else}Нет{/if}</b></p>
<a href="{$self}">полное описание &rarr;</a></td>
</tr>
</table>
</div>
				</textarea>
				</div>


				<div id="board-badge-bb" style="display: none; width: 300px;">
				<span>используйте этот код для вставки в форумы</span><br>
				<textarea onclick="highlight(this)" style="overflow: hidden; width: 300px; height: 70px;" size="70">
[url={$self}][size=5]{$ad->title}[/size][/url]

[url={$self}][img]http://{$BASE_HTTP_HOST}{$photos[0].small}[/img][/url]
[url={$self}]смотреть все фото[/url]

[size=2]{$ad->content} [url={$self}]подробнее –>[/url][/size]

[list]
[*]Модель: [url={$self}]{$mark} {$model} {$ad->getYear()}[/url]
[*]Пробег: [b]{$ad->getProbeg()} км[/b]
[*]Город: [b]{if $ad->getCity()} {$ad->getCity()->name|escape:html} ({$ad->getCity()->getCountry()->name|escape:html}){else}Не указано{/if}[/b]
[*]Цена: [b][color=red]{$ad->getPrice()} руб[/color][/b]
[*]Торг: [b]{if $ad->getTorg()}Да{else}Нет{/if}[/b]
[/list]
[url={$self}]смотреть полное описание –>[/url]
				</textarea>
				</div>



				<div id="board-badge-httplink" style="display: none; width: 300px;">
				<span>используете этот код, чтобы поделиться прямой ссылкой на это объявление</span><br>
				<input onclick="highlight(this)" type="text" name="nick" value="{$self}" style="width: 300px;"/><br>
				</div>
				<!-- Widget end -->
    <h2>Дополнительная информация</h2>
    	<p>{$ad->content}</p>
    </td>
  </tr>
  <tr>
    <td colspan="2"><h2>Контакты</h2>
    	<img src="{$adUser->getAvatar()->getSmall()}"> <a href="/users/profile/userid/{$adUser->id}">{$adUser->nikname}</a>
    	<p>
    	 {assign var=phone value=$adUser->getPhone()}
    	 {assign var=adphone value=$ad->getPhone()}
     	  {if !empty($adphone) }Телефон:&nbsp;{$adphone}
    	  {elseif !empty($phone) }
			Телефон:&nbsp;$phone
    	  {/if}
    	<br>
    	{assign var="icq" value=$ad->getICQ()}
    	{if !empty($icq)}
    	  ICQ:&nbsp;<a onclick='window.open("http://web.icq.com/whitepage/message_me/1,,,00.icq?uin={$icq}&action=message") return  false;' href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin={$icq}&action=message"><img src="http://web.icq.com/whitepages/online?icq={$icq}&img=5" align="absmiddle">{$icq}</a>
    	{/if}  
    	<br>
    	{assign var="skype" value=$ad->getSkype()}
    	 {if !empty($skype)}
     	   Skype:&nbsp;<a href="callto:{$skype}"><img src="http://mystatus.skype.com/smallicon/{$skype}" align="absmiddle">{$skype}</a>
     	 {/if}  
    	<br>
    	</p>
    </td>
  </tr>
 {if !empty($photos)}
  <tr><td colspan="2"><h2>Фотографии</h2>
    	<img name="mainpic" src="{$photos[0].medium}" border="0">
      </td>
  </tr>
  <tr>
    <td colspan="2">
      {foreach from=$photos item=image}
    		<a href="javascript:doPic('{$image.medium}');"><img src="{$image.small}" border="0"></a>
      {/foreach}
    </td>
  </tr>
  {/if} 
</tbody></table>
<table>
  <tr>
    <td>&nbsp;Объявление добавлено:</td>
    <td align="left">{$ad->getRegDate()|date_format:"%d.%m.%Y"}</td>
  </tr>
</table>
<div id="clear"></div>