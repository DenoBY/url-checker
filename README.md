# Тестовое задание
Сервис проверки доступности url-ов

## Установка

```
git clone git@github.com:DenoBY/url-checker.git
cd url-checker
docker-compose up -d

docker-compose exec php bash
composer install
php yii migrate
php yii migrate --migrationPath=@yii/rbac/migrations
php yii rbac/create-admin

Добавить в /etc/hosts на локальной машине
127.0.0.1   frontend.test
127.0.0.1   backend.test

```

## Frontend: 
Добавить url-ы можно по адресу http://frontend.test/url-checker

## Backend:
Список добавленных url-ов http://backend.test/url-checker/urls
Список проверок http://backend.test/url-checker/checks

Доступ в админку
```
login: admin
password: admin
```

