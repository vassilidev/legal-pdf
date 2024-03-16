## Procédure d'installation de l'application PDF - Legal
Prérequis :

- Docker Desktop
- Git (avec SSH)

## Installation local

    git clone git@github.com:vassilidev/legal-pdf.git
    
    cd legal-pdf
	
	cp .env.example .env
	
	docker run  --rm  \
	-u "$(id -u):$(id -g)"  \
	-v "$(pwd):/var/www/html"  \
	-w /var/www/html  \
	laravelsail/php83-composer:latest \
	composer install  --ignore-platform-reqs
	
	./vendor/bin/sail up -d
	
	./vendor/bin/sail artisan key:generate
	
	./vendor/bin/sail migrate:fresh --seed

## Installation PROD

    git clone git@github.com:vassilidev/legal-pdf.git
    
    cd legal-pdf
	
	cp .env.example .env
	
	composer install --no-dev

	php artisan key:generate

    sh deploy.sh

## Stripe (.env)

    STRIPE_KEY=pk_test_
    STRIPE_SECRET=sk_test_

## Langage / Code

   laravel & Blade

## Database

MYSQL en prod 
SQLITE en local

## Liens utile
Laravel : https://laravel.com/

Blade : https://laravel.com/docs/10.x/blade

PHP : https://www.php.net/docs.php

Sail : https://laravel.com/docs/10.x/sail

Docker : https://docs.docker.com/desktop/