install:
	composer install
validate:
	composer validate
lint:
	vendor/bin/phpcs app/ routes/ tests/ resources/
up:
	composer update
start:
	php artisan serve	
test:
	php artisan test