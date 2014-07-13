{literal}
<script language="javascript">
function sendMail ()
{    
	var email = document.getElementById('email');
    // get tpl_key, get email, send
 	var elems = document.getElementsByTagName('input'); 		
	var	len = elems.length;
	
 	for (var i=0; i<len; i++){
 		var e =elems[i];
 		if(e.checked == true){
 		  var tpl_key = e.value;
 		  // alert("1");
 		  xajax_sendDemoMail(tpl_key,email);
 		  // e.checked = false
 		  //alert(e.value+email.value); 
 		}
 	}
}

function validate(){
    var email = document.getElementById('email');
    if(email.value==''){
    	alert("Введите email");
    	return false;	
    }
}
</script>
{/literal}
{include file='admin/menu.tpl'}
<br />Список шаблонов писем:<br />
 <a href="/admin/addMailTemplate/">Добавить шаблон</a>
 
<form action="/admin/sendDemoMail/" method="POST" onsubmit="validate();" >
<table>
<tr>
 <td>#</td>
 <td>ключ</td><td> описание</td>
 <td colspan="3">действия</td>
</tr>
{foreach from=$list item=item key=key }
<tr> 
 <td><input type="checkbox" name="key[{$item->getId()}]" value="{$item->getId()}" id="key_{$item->getId()}"></td>
 <td><a href="/admin/mailtemplate/id/{$item->getId()}/">{$item->getTemplateKey()}</a></td>
 <td><a href="/admin/mailtemplate/id/{$item->getId()}/">{$item->getDescription()}</a></td>
 <td><a href="/admin/editTemplate/id/{$item->getId()}/">изменить</a></td>
<!-- <td><a href="/admin/createMailingList/id/{$item->getId()}/">создать рассылку</a></td> -->
 <td><a href="/admin/deleteTemplate/id/{$item->getId()}/">удалить</a></td>
</tr>
{/foreach}
</table>
<br />
 <input type="text" name="email" value="" style="width:100px"  id="email" />
<br />
 <!--  <input type="button" name="sendTest" value="отправить для теста" onclick="sendMail()" > -->
 <input type="submit" name="save" value="Отправить" >
</form>
 