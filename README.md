## Procédure d'installation de l'application PDF - Legal
Prérequis :

- Docker Desktop
- Git (avec SSH)

## Installation

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

## Liens utile
Laravel : https://laravel.com/

PHP : https://www.php.net/docs.php

Sail : https://laravel.com/docs/10.x/sail

Docker : https://docs.docker.com/desktop/