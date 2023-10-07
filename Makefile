review:
	vendor/bin/psalm
	vendor/bin/phpstan
	vendor/bin/php-cs-fixer check --allow-risky=yes --diff

fixes:
	vendor/bin/php-cs-fixer fix --allow-risky=yes --diff
