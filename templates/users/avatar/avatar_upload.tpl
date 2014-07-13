<script src="/js/upload_fields.js" type="text/javascript"></script>
{strip}
    
{form from=$form name="auForm" id="auForm" enctype="multipart/form-data"}
{form_errors_summary}
<!--<form id="form1" action="{$user->getUserPath('avatarupload')}" method="post" enctype="multipart/form-data">-->
{form_hidden name="do" value="upload"}
<!--<input type="hidden" name="do" value="upload">-->

<div class="Clear"> <span/> </div>
    <table cellpadding="0" cellspacing="0" border="0" class="AvatarsContainer">
      <col width="50%" />
      <col width="50%" />
      <tr>
        <td><h1 class="Colored">Аватары</h1>
          <h2>Загрузить картинки.</h2>
          <div class="Hint">Пожалуйста кликните "обзор" для выбора фотографии на Вашем компьютере.</div>
          <div class="Clear" style="height: 15px;"><span /></div>
		</td>
      </tr>
     </table>

<table id="fields_table" class="UploadFields" cellpadding="0" cellspacing="0" border="0">
	<col width="95%" />
    <col width="5%" />
    {if $avatarsLeft >=5}
		{assign var=loopvalue value=5}
    {else}
    	{assign var=loopvalue value=$avatarsLeft}
    {/if}
    
	{section name=files loop=$loopvalue}
	<tr>
		<td>
		{form_file name="img_"|cat:$smarty.section.files.index_next size="45"} 
		</td>
	</tr>
	{/section}

	{section name=files loop=20 start=$loopvalue}
	<tr title="file_field" style="display:none;">
		<td>
			{form_file name="img_"|cat:$smarty.section.files.index_next size="45"}	
		</td>
	</tr>
	{/section}
	<tr id="more_avatars_link" {if !($avatarsLeft-$loopvalue)} style="display:none;"{/if}>
		<td>
			<a href="#" onclick="show_more_advanced({$avatarsLeft}); return false;" class="MoreLink">+ еще фотографии</a>
		</td>
	</tr>
</table>
<div class="ButtonsUpload">
	{linkbutton name="Отменить" link=$user->getUserPath('avatars')} {form_submit value="Загрузить"}
</div>
<div class="Clear" style="height: 300px"><span /></div>


{/form}
<!--</form>-->
        <div class="Clear" style="height: 10px;"><span /></div>  
{/strip}
