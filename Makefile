stan:
	./vendor/bin/phpstan analyse

cs:
	./vendor/bin/phpcs src resources --colors -p

phpunit:
	./vendor/bin/phpunit --colors

check:
	make cs
	make stan
	make phpunit
