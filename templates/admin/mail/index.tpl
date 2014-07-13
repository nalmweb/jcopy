{literal}

<script language="javascript">
   function checkAll ()
   {
		var m1 = document.getElementById('form-parent'); //document.parent;
 		var len = m1.length;

 		for (var i=1; i < len; i++)
 		{
 		 	var uid = "uid_" + i;
 			var e =document.getElementById(uid);
 			if(e.checked == true)
 				e.checked = false
 			else 	
 				e.checked = true;
 		}
	 }
</script>
{/literal}
{include file='admin/menu.tpl'}
<form name="parent" action="/admin/sendMail/"  method="POST" id="form-parent">
   <input type="submit" name="b" value="Послать всем" > 
</form> 

<!--
<div>
  шаблон для ввода текста.
  <table border="1">    
    <tr><td> <img src="/images/b_check_all.gif" onclick="checkAll()" /></td><td>#</td><td>id</td><td>email</td>
    <td>статус</td>
    </tr>
    <tr><td colspan="5" align="right"><input type="submit" name="b" value="Пригласить" ></td> </tr>    
    {assign var=count value=1}
    {foreach from=$users item=item}
  	 <tr>
  	 <td align="center">
	   <input type="checkbox" name="uid[{$count}]" value="{$item.id}" id = "uid_{$count}"> 
  	   {*if empty($item.is_sent)}
  	     <input type="checkbox" name="uid[{$count}]" value="{$item.id}" id = "uid_{$count}"> 
  	   {else}
  	     <input type="checkbox" name="uid[{$count}]" value="{$item.id}" id = "uid_{$count}" checked> 
  	   {/if*}
  	  </td>  	 
  	  <td>{$count})</td><td>{$item.id}</td> <td>{$item.login}</td>
  	  <td>{if !empty($item.is_sent)} <font style="color:#57DB20;font-weight:bold;">приглашен</font>{else}-{/if}</td>
  	</tr>
	 {assign var=count value=$count+1} 
   {/foreach}
   <tr><td colspan="5" align="right"><input type="submit" name="b" value="Пригласить" > </td> </tr>
  </table>  
</div>
--> 
