User {$invitor->login} invites you to be {if $invitor->gender == 'male'}him{else}his{/if} friend!

To accept invitation, please follow this link - {$recipient->getUserPath('friend')}cmd/add/user/{$invitor->id}

To decline invitation, please do nothing, ok? :)

You may view your friends following this link - {$recipient->getUserPath('friends')}

