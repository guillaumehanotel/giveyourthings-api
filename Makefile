include .env
export
.PHONY: help test
.DEFAULT_GOAL= help

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

update-database:
	mysql -u $(DB_USERNAME) -p $(DB_DATABASE) < database/giveyourthings_update.sql

serve:
	@php -S localhost:8080 -t public public/index.php
