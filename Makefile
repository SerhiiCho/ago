stan:
	./vendor/bin/phpstan analyse

cs:
	./vendor/bin/phpcs src resources --colors -p

test:
	./vendor/bin/phpunit --colors tests

pint:
	./vendor/bin/pint --test

check:
	make cs
	make stan
	make test
	make pint

push:
	make check
	git pull origin HEAD
	git push origin HEAD

.DEFAULT_GOAL := push