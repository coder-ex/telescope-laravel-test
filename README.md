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

## Развертывание проекта

### контейнер для БД собирается в отдельном внешнем каталоге (за пределами проекта)
>
    пример docker-compose для БД
        version: "3.5"

        services:
        mysql:
            build:
            context: docker/mysql8
            image: dev-db/mysql8-db
            container_name: dev-mysql8
            command: --default-authentication-plugin=mysql_native_password
            env_file:
                - .env.local
            user: '1000'
            restart: always
            environment:
                MYSQL_ROOT_PASSWORD: qwertynet
                MYSQL_DATABASE: ${MYSQL_DB}
                MYSQL_USER: ${MYSQL_USER}
                MYSQL_PASSWORD: ${MYSQL_PASS}
            volumes:
                - ${DB_PATH_HOST}:/var/lib/mysql
            ports:
                - "33060:3306"
            networks:
                db_net:
                    ipv4_address: ${IPV4_ADDR_DB}

        phpmyadmin:
            image: phpmyadmin/phpmyadmin:latest
            container_name: dev-pma
            restart: always
            depends_on:
                - mysql
            ports:
                - "8080:80"
            env_file:
                - .env.local
            environment:
                PMA_ARBITRARY: 1
                PMA_HOST: ${MYSQL_HOST}
                PMA_USER: ${MYSQL_USER}
                PMA_PASSWORD: ${MYSQL_PASS}
            volumes:
                - /session
            networks:
                - db_net

        volumes:
            mysql:
                driver: local

            networks:
            db_net:
                name: src_${NAME_NET}
                external: true

    пример Docker файла
        FROM mysql:8.2
        RUN set -eux; \
            microdnf install -y yum
        RUN yum install -y perl wget
        RUN mkdir /source && mkdir /source/db
        ADD ./my.cnf /etc/mysql/conf.d/my.cnf

    my.snf настраивается исходя из предпочтений
    .env.local в каталоге для БД
        PATH_SERVICE=./service

### команды make файла
>
    1. make build - сборка связки php + nginx контейнера
    2. build-db-debug - сборка mysql8 БД (необходимо предварительно скорректировать пути в make файле)
    3. после запуска п.1-2, положить контейнеры
    4. make up - старт связки контейнеров 
    5. make down - остановить и удалить контейнеры
    прим: все команды доступны в make файле

### после подготовительных работ по развертыванию проекта
>
    1. в командной строке законнектиться в контейнер docker exec -it telescope-php /bin/bash
    2. npm run dev - запустить на сборку js
    3. php artisan queue:work - запустить слушателя очереди

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

