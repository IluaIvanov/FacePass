# Инструкция

## Установка:

Для того, чтобы развернуть проект требуется установка следующего ПО:

- `docker >= 18.0` _([install](https://docs.docker.com/engine/install/ubuntu/))_
-	`docker-compose >= 1.22` _([install](https://docs.docker.com/compose/install/))_
- `make >= 4.1` _(install: `apt-get install make`)_

### Данная сборка docker включает в себя:

- PHP-FPM8.1
- PostgreSQL13.7
- PgAdmin
- NGINX

Все команды для работы с контейнерами запускаются из корневого каталога.

- Первым шагом следует собрать контейнер app, для этого запускается команда `make build`.
- Вторым шагом запускается команда `make install`.

В последствии для запуска/отключения контейнеров используется команда `make up/down`. Более подробную инструкцию по командам можно посмотреть следующим образом: `make help`.

## Настройка:

Для настройки следует скопировать `.env.example` в `.env` файл. 

Далее следует запустить команду генерации ключа:
```bash 
$ make app-c command="php artisan key:generate"
```

Следующий шаг:
```bash 
$ make app-c command="php artisan migrate"
```

Для работы скрипта требуется заполнить обязательный параметр `VK_ACCESS_TOKEN` в `.env` файле. Этапы получения токена описаны [по ссылке](https://yakovtsov.ru/poleznoe/kak-poluchit-token-vkontakte#Как_получить_ключ_доступа_приложения) 

Для запуска импорта пользователей (в данном случае импортируются друзья заданного пользователя) используется команда, где в качестве аргумента передается ID пользователя или короткое имя:
	```bash
		make app-c command="php artisan user:import {user}"
	```

После запуска контейнеров ресурс будет доступен по ссылке: http://localhost:8080 (здесь же приведены ссылки на методы API), для того, чтобы получить доступ к БД через интерфейс предустановлен phpPgAdmin, доступ к нему осуществляется по ссылке: http://localhost:5454. Данные для входа:

- Логин: dev
- Пароль: 123
- БД: dev

### Возможные проблемы:
#### Проблема:
«he stream or file "/var/www/local/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied The exception occurred while attempting to log: The stream or file "/var/www/local/storage/logs/laravel.log" could not be»
#### Решение: 
Следует дать права на папку ./src, например, sudo chmod 777 -R src/
