User {$invitor->login} joins you as friend and now {if $invitor->gender == 'male'}him{else}his{/if} is your mutual friend!

You may view your friends following this link - {$recipient->getUserPath('friends')}

