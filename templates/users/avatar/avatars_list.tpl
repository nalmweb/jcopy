
    {strip}
    <table cellpadding="0" cellspacing="0" border="0">
      <col width="50%" />
      <col width="50%" />
      <tr>
        <td>
          <h2>Загрузите и сохраните картинки, которые Вы желаете установить в качестве аватаров</h2>
          <div class="Hint">{t}Вы можете добавить еще {$avatarsLeft} аватар {/t}</div>
          <div class="Clear" style="height: 15px;"><span /></div>
          {if $avatarsLeft > 0}
            {linkbutton name="Добавить еще..." link="/users/avatarupload/$login" }
          {/if}
          <div class="Clear"><span /></div>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
			<h3>Доступные аватары</h3>
			<table cellpadding="0" cellpadding="0" border="0">
          {foreach item=a name='avatars' from=$avatarsList}
          {if $smarty.foreach.avatars.iteration % 6 == 1}
	      <tr> {/if}
	        <td><a href="#" onclick="xajax_loadavatar({$a->getId()});"> <img src="{$a->setWidth(50)->setHeight(50)->setBorder(1)->getImage()}" border="0"> </a></td>
	        {if $smarty.foreach.avatars.iteration % 6 == 0} </tr>
	      {/if}
	      {foreachelse}
      <tr>
        <td align="center" style="padding-top:30px; padding-bottom:30px;">Аватары отсутствуют</td>
      </tr>
      {/foreach}
    </table>
    <div class="Clear"><span /></div>
    <input type="hidden" id = "xa_avatar_id" name="avatar_id" value="{$currentAvatar->getId()}" />
    <input type="hidden" id = "xa_default" name="avatar_defaule" value="{$currentAvatar->getByDefault()}" />
    <div id="xa_setprimary" style="visibility:hidden">
    {linkbutton name="Отметить это фото как основное" link=$user->getUserPath('avatarmakeprimary/avatar')|cat:$currentAvatar->getId() id="xa_makeprimary"}
    <!--<div class="co-button"><a id="xa_makeprimary" href="$group->getGroupPath('avatarmakeprimary/avatar')}{$currentAvatar->getId()}">Set as My Primary Photo</a></div>-->
    </div>
        {if $currentAvatar->getId() === 0}
            <div id="xa_deletelink" style="display:none;"> 
        {else}
            <div id="xa_deletelink"> 
        {/if}         
        {linkbutton name="Удалить" link=$user->getUserPath('avatardelete')|cat:'avatar/'|cat:$currentAvatar->getId() id="xa_deleteurl"}
            </div>            
      </td>
      <td> {if $avatarsList}
		<h3>Это мой основной аватар</h3>
        <table width=95% border="0">
          <tr>
            <td><img id="xa_avatar_path" src="{$currentAvatar->setWidth(175)->setHeight(215)->setBorder(1)->getImage()}" border="0" width="175">
                <!--div class="FileName">filename.jpg</div-->
              <div id="xa_delete" style="visibility:hidden" class="VyPrimaryPhotoText">{t}Мое основное фото{/t}</div>
              <script>
                if (document.getElementById("xa_default").value == 1) document.getElementById("xa_delete").style.display="";
                if (document.getElementById("xa_avatar_id").value == 0)  document.getElementById("xa_deletelink").style.display="none";
              </script>
          </tr>
        </table>
        {/if} </td>
      </tr>
      </table>
{/strip}