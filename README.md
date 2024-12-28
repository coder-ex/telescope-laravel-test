## Тестовое ТЗ от Телескоп

### Настройка Телеграм бота
>
    1. В файле .env прописать в TELEGRAM_BOT_TOKEN токен телеграм бота от имени которого отправляем тестовые сообщения в канал телеграм
    2. В файле config->channel_manager в секции TG.bots.TG_NOTIFY_BOT_1.bot прописать имя телеграм бота

### Настройка E-Mail
>
    1. В .env файле прописать переменные, как пример для smtp от yandex [yandex support](https://yandex.ru/support/yandex-360/customers/mail/ru/mail-clients/others):
    - MAIL_MAILER=smtp
    - MAIL_HOST=smtp.yandex.com
    - MAIL_PORT=465
    - MAIL_USERNAME=_email_akkount_
    - MAIL_PASSWORD=_password_account_
    - MAIL_ENCRYPTION=tls
    - MAIL_FROM_ADDRESS=_email_
    - MAIL_FROM_NAME="${APP_NAME}"

### Правильный алгоритм создания телеграм бота
>
    Шаг 1: Создание бота в Telegram
    1. Откройте Telegram и найдите бота @BotFather (https://t.me/botfather).
    2. Используйте команду /newbot для создания нового бота.
    3. Следуйте инструкциям, чтобы получить токен вашего бота. Сохраните этот токен, он вам понадобится.
    
    Шаг 2: Получение chat_id пользователя
    Чтобы отправить сообщение конкретному пользователю, вам нужно знать его chat_id. Вы можете сделать это, отправив сообщение вашему боту и получив chat_id через API.
    1. Отправьте любое сообщение вашему боту. 												[делается в самом телеграм, что бы в ответ не прилетало result==[]]
    2. Используйте следующий URL в браузере, заменив YOUR_BOT_TOKEN на токен вашего бота:	[обратить внимание на приставку bot перед токеном]
	https://api.telegram.org/botYOUR_BOT_TOKEN/getUpdates
   	проверка данных: бота https://api.telegram.org/botYOUR_BOT_TOKEN/getMe
    3. Найдите chat_id в ответе JSON.