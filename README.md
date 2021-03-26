Для сборки используется Docker

Скопируйте файл .env.example в папке docker/image/php, укажите ему имя .env

Собираем и запускаем контейнеры
- docker-compose up -d

<b>Создание пользователя mysql</b>

запустите интерактивную оболочку bash в контейнере db
- docker-compose exec db bash

Выполните внутри контейнера вход в административную учетную запись MySQL root (Пароль указан в файле docker-compose)
- mysql -u root -p

Создаём нового пользователя для нашей бд и задаём ему права
- create user 'delivery_user'@'%' identified by '123';
- GRANT ALL ON delivery_bd.* TO 'delivery_user'@'%';

Обновите привилегии, чтобы уведомить сервер MySQL об изменениях:
- FLUSH PRIVILEGES;

Закройте MySQL:
- EXIT;

Выйдите из контейнера:
- exit

Следующая команда будет генерировать ключ и скопирует его в файл .env, 
гарантируя безопасность сеансов пользователя и шифрованных данных:
- docker-compose exec app php artisan key:generate

Теперь у вас есть все необходимые настройки среды для запуска приложения. 
Чтобы кэшировать эти настройки в файле, ускоряющем загрузку приложения, запустите команду:
- docker-compose exec app php artisan config:cache

Добавление ключей в БД для Laravel Passport
- docker-compose exec app php artisan passport:install

API документация находится по адресу 
{server}/redoc