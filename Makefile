install:
	composer install
validate:
	composer validate
lint1:
	vendor/bin/phpcs app/ routes/ tests/
beauty:
	composer exec --verbose phpcbf -- --standard=PSR12 app routes tests
up:
	composer update
test:
	php artisan test
test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
test-coverage-html:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-html build/coverage/html
check:
	vendor/bin/phpstan analyse --level 5 src
start:
	php artisan serve	
test1:
	php artisan test tests/Feature/TaskStatusControllerTest.php
test2:
	php artisan test tests/Feature/TaskControllerTest.php
test3:
	php artisan test tests/Feature/LabelTest.php