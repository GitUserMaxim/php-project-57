install:
	composer install
validate:
	composer validate
lint:
	vendor/bin/phpcs app/ routes/ tests/
beauty:
	composer exec --verbose phpcbf -- --standard=PSR12 app routes tests
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
	php artisan test tests/Feature/TaskStatusControllerTest.php tests/Feature/TaskControllerTest.php tests/Feature/LabelTest.php tests/Feature/TaskStatusRoutesTest.php tests/Feature/LabelsRoutesTest.php tests/Feature/TasksRoutesTest.php