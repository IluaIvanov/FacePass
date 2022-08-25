# Инструкция

## Установка:

Для того, чтобы развернуть проект требуется установка следующего ПО:

- `docker >= 18.0` _([install](https://docs.docker.com/engine/install/ubuntu/))_
-	`docker-compose >= 1.22` _([install](https://docs.docker.com/compose/install/))_
- `make >= 4.1` _(install: `apt-get install make`)_

Все команды для работы с контейнерами запускаются из корневого каталога.

- Первым шагом следует собрать контейнер app, для этого запускается команда `make build`.
- Вторым шагом запускается команда `make install`.

В последствии для запуска/отключения контейнеров используется команда `make up/down`. Более подробную инструкцию по командам можно посмотреть следующим образом: `make help`.

## Настройка:

Для настройки следует скопировать `.env.example` в `.env` файл. 

Далее следует запустить команду генерации ключа:
	```bash make app-c command="php artisan key:generate"```

Следующий шаг:
	```bash make app-c command="php artisan migrate"```
 
Для настройки частоты обновления данных в БД используется планировщик (по умолчанию обновляется каждые 2 часа), для настройки значения следует перейти по следующему пути: ./src/app/Console/Kernel.php. При изменение значения требуется перезагрузка контейнеров (make restart).

После запуска контейнеров ресурс будет доступен по ссылке: http://localhost:8080, для того, чтобы получить доступ к БД через интерфейс предустановлен Adminer, доступ к нему осуществляется по ссылке: http://localhost:5454. Данные для входа (пароль: 123):

После настройки скрипта следует подождать настроенный интервал для того, чтобы значения полученных курсов валют отобразились в настройках виджета. 

Возможные проблемы:
	Проблема: «he stream or file "/var/www/local/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied The exception occurred while attempting to log: The stream or file "/var/www/local/storage/logs/laravel.log" could not be»
	Решение: Следует дать права на папку ./src, например, sudo chmod 777 -R src/



<p align="center">
  <img src="https://miro.medium.com/max/1200/1*A4jx36gnjKSZNSlNP6AJlg.png" alt="" style="width: 100%" />
</p>

## System requirements

For local application starting (for development) make sure that you have locally installed next applications:

- `docker >= 18.0` _(install: `curl -fsSL get.docker.com | sudo sh`)_
- `docker-compose >= 1.22` _([installing manual][install_compose])_
- `make >= 4.1` _(install: `apt-get install make`)_

## Used services

This application uses next services:

- PHP-FPM8.1
- PostgreSQL13.7
- PgAdmin
- NGINX
- NODE16.6

Declaration of all services can be found into `./docker-compose.yml` file.

## Work with application

Most used commands declared in `./Makefile` file. For more information execute in your terminal `make help`.

Here are just a few of them:

Command signature | Description
----------------- | -----------
`make build` | Build all Docker images from using own Docker files
`make up`    | Run all application containers into background mode
`make down`  | Stop all started application containers
`make restart` | Restart all application containers
`make shell` | Start shell into application container
`make install` | Make install all `composer` and `node` dependencies
`make watch` | Run `npm run dev` _(for frontend-development)_
`make init` | Make **full** application initialization

After application starting you can open [127.0.0.1:8080](http://127.0.0.1:8080/) in your browser.
After application starting you can open [127.0.0.1:5050](http://127.0.0.1:5050/) in your browser from PhpPgAdmin.

### Fast application starting

Just execute into your terminal next commands:

```bash
$ git clone https://github.com/ilua1777/dockerLaravel8.git ./laravel-project && cd $_
```