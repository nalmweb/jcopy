{include file='admin/menu.tpl'}
  <br />
  <br />
  <br />
{literal}
<script language="javascript" >
 function checkForm(){
   var elem=document.getElementById('key').selectedIndex;
   if(elem==0){
      alert("Выберите шаблон для отправки");
      return false;
   }
   return true;
 }
</script>
{/literal}
<form name="massmail" action="/admin/sendMail/" method="POST"  onsubmit="if(checkForm()) return true; else return false;">
 Отправка писем пользователям:
<select name="template_key"  id="key">
   <option value="0">Выберите шаблон:</option>
  {foreach from=$list item=item}
     <option value="{$item->getId()}">{$item->getDescription()} ({$item->getTemplateKey()})</option>
  {/foreach}
</select>
<input type="submit" name="send" value="Отправить" >
</form>


  <br />
  <br />
  <br />
    <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  

<div id="clear"></div>