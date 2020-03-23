default: help

help:
	@echo "Usage:"
	@echo "     make [command]"
	@echo "Available commands:"
	@grep '^[^#[:space:]].*:' Makefile | grep -v '^default' | grep -v '^_' | sed 's/://' | xargs -n 1 echo ' -'

fix-code-style:
	./vendor/bin/php-cs-fixer fix -v

test:
	$(MAKE) test-unit

test-unit:
	vendor/bin/phpunit --testsuite=unit

test-coverage:
	vendor/bin/phpunit --coverage-html=./coverage