{literal}
<script language="JavaScript">
  <!-- Original:  Jenny Blewitt (webmaster@webdesignsdirect.com)-->
  <
  !--Web
  Site:  http://www.webdesignsdirect.com 		   -->
    <!-- This script and many more are available free online at-->
    <
  !--The
  JavaScript
  Source
  !!http
  ://javascript.internet.com-->
  <
  !--Begin
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
  //  End -->
</script>
{/literal}
<h1><a href="">{$crumbs[0]}</a> / <a href="">{$crumbs[1]}</a> / <a
  href="/board/cat/{$ad->getMark()}"> {$ad->getMark()} </a> / {$ad->getModel()} </h1>
<h1>Объявление: {$ad->title}</h1>
<table border="0" width="800">
  <tbody>
  <tr style="padding-right: 50px;">
    <td width="250">
      <div style="float: left;">Год выпуска:</div>
      <div style="float: right;">{$ad->getYear()}</div>
    </td>
    <td width="250">
      <div style="float: left;">Пробег:</div>
      <div style="float: right;">{$ad->getProbeg()} км</div>
    </td>
  </tr>
  <tr>
    <td>
      <div style="float: left;">Объем двигателя:</div>
      <div style="float: right;">{$ad->getVolume()} см<sup>3</sup></div>
    </td>
    <td>
      <div style="float: left;">Состояние:</div>
      <div style="float: right;">{$ad->getCondition()}</div>
    </td>
  </tr>
  <tr>
    <td>
      <div style="float:left;">Мощность:</div>
      <div style="float: right;">{$ad->getPower()} л.с.</div>
    </td>
    <td>
      <div style="float:left;">Город:</div>
      <div style="float: right;">{$ad->getCity()->name|escape:html} ({$ad->getCity()->getCountry()->name|escape:html})
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div style="float: left;">КПП:</div>
      <div style="float: right;">{$ad->getKPP()}</div>
    </td>
    <td>
      <div style="float: left;">Торг возможен:</div>
      <div style="float: right;">{if $ad->getTorg()}Да{else}Нет{/if}</div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div align="right"><a href="#">смотреть все характеристики для {$ad->getMark()} {$ad->getModel()} в каталоге </a>
      </div>
      <h2>Дополнительная информация</h2>

      <p>{$ad->content|escape:html}</p>
    </td>
  </tr>
  <tr>
    <td colspan="2"><h2>Контакты</h2>
      <img src="{$adUser->getAvatar()->getSmall()}"> <a
        href="/users/profile/userid/{$adUser->id}">{$adUser->nikname}</a>

      <p>Телефон: {$ad->getPhone()|default:""}<br>

      {assign var="icq" value=$ad->getICQ()|default:"" }
        ICQ: <a onclick="window.open(" http:="" web.icq.com="" whitepages="" message_me="" 1,,,00.icq?uin="{$icq}&amp;action=message&quot;);"
        return="" false;=""
        href="http://web.icq.com/whitepages/message_me/1,,,00.icq?uin=8039585&amp;action=message"><img
          src="http://web.icq.com/whitepages/online?icq={$icq}&amp;img=5" align="absmiddle">{$icq}</a>

        <br>
      {assign var="skype" value=$ad->getSkype()|default:"" }
        Skype: <a href="callto:{$skype}"><img src="http://mystatus.skype.com/smallicon/{$skype}"
                                              align="absmiddle">{$skype}</a>
        <br>

        <a href="">Написать личное сообщение</a>
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2"><h2>Фотографии</h2>
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
  <tr>
    <td>&nbsp;</td>
    <td>Объявление добавлено {$ad->reg_date|date_format:"%d.%m.%Y"}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
<div id="clear"></div>