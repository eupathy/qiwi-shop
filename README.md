qiwi-shop
=========

Gateway emulates shop for the qiwi system (REST Protocol).

# Requirements

- php >=5.3.0
- Laravel Framework 4.1.*
- MySQL Database
- Laravel queue driver configuration
- User auth identifier in your web project

# Uses

- bootstrap cdn
- jquery cdn

# Installation

## Composer

Package only:

    {
        "require": {
            "fintech-fab/bank-shop": "dev-master"
        },
    }

Package dependency:

    {
        "require": {
	        "php": ">=5.3.0",
	        "laravel/framework": "4.1.*",
            "fintech-fab/bank-shop": "dev-master"
        },
	    "require-dev": {
		    "phpunit/phpunit": "3.7.*",
		    "mockery/mockery": "dev-master"
	    },
    }
