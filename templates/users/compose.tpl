{strip}

{titledcontentblock width="100%" title="`$currentUser->login`'s Account" headerColor=$menuColor}

    {profilemenu color=$menuColor active="profile"}

    {if $currentUser->id == $user->id}

        {tab}

            {tabitem link=$currentUser->getUserPath('profile') active="1"}View Profile{/tabitem}

            {tabitem link=$currentUser->getUserPath('edit')}Edit Profile{/tabitem}

            {tabitem link=$currentUser->getUserPath('friends')}Friends{/tabitem}

            {tabitem link=$currentUser->getUserPath('messages')}Messages{/tabitem}

            {tabitem link=$currentUser->getUserPath('addressbook')}Addressbook{/tabitem}

        {/tab}

    {/if}


	
    {tab}
        {tabitem link=$currentUser->getUserPath('profile') active="0"}Preview{/tabitem}
        {tabitem link=$currentUser->getUserPath('compose') active="1"}Compose{/tabitem}
    {/tab}
	
	{include file="ddpages/ddpages_form_profile.tpl"}	
	
	

    <table cellpadding="0" cellspacing="0" width="100%" border="0">

        <tr>

            <td valign="top" align="center" width="30%">

                <table cellpadding="5" cellspacing="0" border="0">

                    <tr>

                        <td>&nbsp;</td>

                    </tr>

                    <tr>

                        <td align="center">

                            <img src="{$currentUser->getAvatar()->getMedium()}" border="0" width="75">

                        </td>

                    </tr>

                    <tr>

                        <td align="center">
						<a href="{$currentUser->getUserPath('avatars')}">More Photos</a></td>

                    </tr>

                    <tr>

                        <td align="center">
                            {if ($currentUser->id != $loginnedUser->id)}
                                {if (($friendStatus == 'ijt') || ($friendStatus == 'hnj'))}
                                    <a href="{$loginnedUser->getUserPath('friend')}mode/tjm/cmd/add/user/{$currentUser->id}/">{t}Invite {$currentUser->login} to be your friend{/t}</a>
                                {elseif ($friendStatus == 'tjm')}
                                   <a href="{$loginnedUser->getUserPath('friend')}mode/tjm/cmd/add/user/{$currentUser->id}/">{t}Join {$currentUser->login} as a friend{/t}</a>
                                {/if}
                            {/if}

                        </td>

                    </tr>

                </table>

            </td>

            <td valign="top">

                <table cellpadding="5" cellspacing="0" width="100%" border="0">

                    <tr>

                        <td class="profile_label">&nbsp;</td>

                        <td class="profile_value" align="right"><a href="{$currentUser->getUserPath('print')}" target="_blank"><img src="/images/profile/print.gif" border="0"></a></td>

                    </tr>

                    <tr>

                        <td class="profile_label">{t}Username:{/t}</td>

                        <td class="profile_value">{$currentUser->login|escape:"html"}</td>

                    </tr>

                    <tr>

                        <td class="profile_label">{t}Age:{/t}</td>

                        <td class="profile_value">{if !$currentUser->isBirthdayPrivate}{$currentUser->age} Yr old{/if}</td>

                    </tr>

                    <tr>

                        <td class="profile_label">{t}Gender:{/t}</td>

                        <td class="profile_value">

                            {if $currentUser->gender eq 'male'}

                                {t}Male{/t}

                            {else}

                                {t}Female{/t}

                            {/if}

                        </td>

                    </tr>

                    <tr>

                        <td class="profile_label">{t}Real Name:{/t}</td>

                        <td class="profile_value">

                            {if $currentUser->realname}

                                {$currentUser->realname|escape:"html"}

                            {else}

                                {$currentUser->firstname|escape:"html"} {$currentUser->lastname|escape:"html"}

                            {/if}

                        </td>

                    </tr>

                    <tr>

                        <td style="border-bottom: 1px solid #E6F1D3;" colspan="2" height="1"><img src="/images/px.gif" width="1" height="1"></td>

                    </tr>

                    <tr>

                        <td class="profile_label">{t}Location:{/t}</td>

                        <td class="profile_value">

                            {$currentUser->getCity()->name|escape:"html"}, {$currentUser->getState()->name|escape:"html"}, {$currentUser->getCountry()->name|escape:"html"}

                        </td>

                    </tr>

                    {if $currentUser->id == $user->id}

                    <tr>

                        <td style="border-bottom: 1px solid #E6F1D3;" colspan="2" height="1"><img src="/images/px.gif" width="1" height="1"></td>

                    </tr>

                        <tr>

                            <td class="profile_label" valign="top">{t}Groups:{/t}</td>

                            <td valign="top">

                                {foreach item=g from=$currentUser->getGroupsList()}

                                	<a href="{$g->group_adv_path}{$LOCALE}/summary/"><b>{$g->name|escape:"html"}</b></a><br>

                                {/foreach}

                            </td>

                        </tr>

                    {/if}

                    <tr>

                        <td class="profile_label"></td>

                        <td class="profile_value"></td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

{/titledcontentblock}

{/strip}

