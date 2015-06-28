Qiwi Shop Emulator
=========


Эмулятор интернет магазина для работы с сервером QIWI.
Подробная инструкция по использованию находится в разработке.
Полноценно работает с пакетом QIWI-SDK, так же можно протестировать работу используя эмулятор сервера QIWI:

- QIWI-SDK: https://github.com/fintech-fab/qiwi-sdk
- QIWI-gate: https://github.com/fintech-fab/qiwi-gate

# Требования

- php >=5.4.0
- Laravel Framework >= 4.1.*
- MySQL Database
- Laravel queue driver configuration
- User auth identifier in your web project

# Используется

- bootstrap cdn
- jquery cdn

# Установка`

## Composer

Только пакет:

    {
        "require": {
            "fintech-fab/qiwi-shop": "dev-master"
        },
    }

Пакет с зависимостями:

    {
        "require": {
	        "php": ">=5.4.0",
	        "laravel/framework": ">=4.1",
            "fintech-fab/qiwi-shop": "dev-master"
        },
	    "require-dev": {
		    "phpunit/phpunit": "4.3.*@dev",
		    "mockery/mockery": "dev-master"
	    },
    }

Запустите:

	composer update
	php artisan dump-autoload

## Локальные настройки

Добавьте service provider в `config/app.php`:

	'providers' => array(
		'FintechFab\QiwiShop\QiwiShopServiceProvider'
	)

### Соединение с базой данных назовите 'ff-qiwi-shop'

Add to `config/#env#/database.php`:

```PHP
'connections' => array(
	'ff-qiwi-shop' => array(
		'driver'    => 'mysql',
		'host'      => 'your-mysql-host',
		'database'  => 'your-mysql-database',
		'username'  => 'root',
		'password'  => 'your-mysql-password',
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => 'your-table-prefix',
	),

),
```

## Миграции

Выполните миграции базы:

	php artisan migrate --package="fintech-fab/qiwi-shop" --database="ff-qiwi-shop"

### Получение id пользователя для авторизации:

По умолчанию id пользователя определяется `Auth::user()->getAuthIdentifier()`.
Вы можете установить целочисленное значение (например `'user_id' => 1`), или использовать какую-то вашу функцию
определения id пользователя.

Для этого опубликуйте настройки из пакета:

	php artisan config:publish --path=vendor/fintech-fab/qiwi-shop/src/config fintech-fab/qiwi-shop

И измените настройки получения id пользователя для вашего проекта `app/config/packages/fintech-fab/qiwi-shop/config.php`:

	'user_id' => 'user-auth-identifier',

### Поьзовательские настройки:

После публикации настроек установите ваши параметры

```PHP
'provider' => array(
		'name'     => 'your-company-name',
		'id'       => 'your-qiwi-gate-id',
		'password' => 'your-qiwi-gate-password',
		'key'      => 'your-qiwi-gate-key',
	),

'lifetime' => 'validity-of-order', //Количество дней

'gateUrl'  => 'url-to-qiwi-gate',  //URL на сервер QIWI
'payUrl'   => 'url-for-pay-bill-in-qiwi-gate', //URL для оплаты счёта на сервере QIWI

```

## Использование

Теперь пакет полностью готов к работе на вашем сайте.

Подробнее о работе пакета - /qiwi/shop/orders/about

Создание заказа - /qiwi/shop/orders/create

Таблица заказов и действия с ними - /qiwi/shop/orders


## Для разработчиков

### Workbench migrations

	php artisan migrate:reset --database="ff-qiwi-shop"
	php artisan migrate --bench="fintech-fab/qiwi-shop" --database="ff-qiwi-shop"

	php artisan migrate:reset --database="ff-qiwi-shop" --env="testing"
	php artisan migrate --bench="fintech-fab/qiwi-shop" --database="ff-qiwi-shop" --env="testing"

### Package migrations

	php artisan migrate:reset --database="ff-qiwi-shop"
	php artisan migrate --package="fintech-fab/qiwi-shop" --database="qiwi-shop"

	php artisan migrate:reset --database="ff-qiwi-shop" --env="testing"
	php artisan migrate --package="fintech-fab/qiwi-shop" --database="ff-qiwi-shop" --env="testing"

### Workbench publish

	php artisan config:publish --path=workbench/fintech-fab/qiwi-shop/src/config fintech-fab/qiwi-shop


