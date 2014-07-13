<script type="text/javascript" src="/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/js/swfupload/handlers.js"></script>
{strip}
{include file='admin/menu.tpl'}
Добавление шаблона:
 
<form {$formContent.attributes} >
 {$formContent.hidden}
	    <div id="page_title"><h1>Создание шаблона письма</h1></div>
	    <br>
		<div id="news_block">
		   {if $formContent.errors}
		   	  {foreach item=e from=$formContent.errors}{$e}<br>{/foreach}
           {/if}
		   {$formContent.description.label} {$formContent.description.html}
		   <br><br>
		   {$formContent.templateKey.label} {$formContent.templateKey.html}
		   <br><br>
		   <br>
			 {$formContent.content.label}<br>
			 {$formContent.content.html}
			<br>
		 <div style="padding-left:140px;padding-top:20px;">
		   {submitbutton value="Добавить" }
		 </div>
	</div>	
</form>



{/strip}
