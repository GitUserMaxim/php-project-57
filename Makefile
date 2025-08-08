install:
	composer install
validate:
	composer validate
lint:
	vendor/bin/phpcs app/ routes/ tests/ resources/
fix:
	vendor/bin/phpcbf app/ routes/ resources/ tests/ bootstrap/ database/ lang/
up:
	composer update
test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
test-coverage-html:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-html build/coverage/html
check:
	vendor/bin/phpstan analyse --level 5 src
start:
	php artisan serve	
test:
	php artisan test