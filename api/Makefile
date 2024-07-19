.DEFAULT_GOAL := help

.PHONY: validate
validate: ## Validate the composer.json file.
	@composer validate

.PHONY: check
check: ## Dry run PHP-CS-Fixer.
	@./vendor/bin/php-cs-fixer check --verbose --diff --stop-on-violation

.PHONY: fix
fix: ## Run PHP-CS-Fixer.
	@./vendor/bin/php-cs-fixer fix

.PHONY: analyze
analyze: ## Run PHPStan.
	@./vendor/bin/phpstan analyse

.PHONY: lint
lint: validate check analyze ## Run all linting commands.

.PHONY: clear
clean: ## Clear Symfony and PHP-CS-Fixer cache.
	@sudo rm -rf ./php-cs-fixer.cache
	@sudo rm -rf ./var

.PHONY: help
help: ## Show this help message.
	@echo "Usage:"
	@echo "  make <target>"
	@echo ""
	@echo "Targets:"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
