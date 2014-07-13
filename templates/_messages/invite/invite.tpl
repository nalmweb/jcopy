{capture name="_from_"}
    "Регистрация на 'Мото Друзьях'" <motosite@{$DOMAIN_FOR_EMAIL}>
{/capture}

{capture name="_subject_"}
   Подтверждение вашей регистрации на 
{/capture}

{capture name="_mail_html_part_"}
Привет {$recipient->nikname}:<br>
<br>
Спасибо за присоединение к нашей команде!<br>
<br>
Кликни по данному линку для подтверждения твоей регистрации в 'Мото Друзьях': {$BASE_URL}/registration/index/code/{$recipient->registerCode}/
<br>
Ваш новый пароль: {$recipient->password} <br />
Пароль можно изменить после регистрации.<br />

Спасибо, <br>
<br>
Команда 'Мото Друзья'.
{/capture}
