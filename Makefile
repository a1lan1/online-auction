.PHONY: start install dbs restart rebuild wfg clear test lint ide up down

SAIL := ./vendor/bin/sail

start-app:
	make install
	make dbs
	$(SAIL) yarn dev

install:
	composer install
	$(SAIL) build
	$(SAIL) up -d
	$(SAIL) artisan key:generate
	$(SAIL) yarn install

up:
	$(SAIL) up -d

down:
	$(SAIL) down

dbs:
	$(SAIL) artisan app:cleanup
	$(SAIL) artisan horizon:forget --all
	$(SAIL) artisan migrate:fresh --seed
	$(SAIL) artisan search:reindex
	make clear

restart:
	$(SAIL) down
	$(SAIL) up -d

rebuild:
	$(SAIL) down -v
	$(SAIL) build --no-cache
	$(SAIL) up -d

wfg:
	$(SAIL) artisan wayfinder:generate

clear:
	$(SAIL) artisan config:clear
	$(SAIL) artisan cache:clear
	$(SAIL) artisan route:clear
	$(SAIL) artisan optimize:clear

test:
	rm -rf coverage coverage.xml public/build
	$(SAIL) yarn
	$(SAIL) yarn build
	$(SAIL) npx playwright install
	$(SAIL) artisan config:clear --env=testing
	$(SAIL) artisan test --coverage --parallel

lint:
	make ide
	./vendor/bin/phpstan analyse
	./vendor/bin/rector process --ansi
	./vendor/bin/pint --parallel
	yarn format
	yarn lint

ide:
	$(SAIL) artisan ide-helper:generate
	$(SAIL) artisan ide-helper:models -RW
	$(SAIL) artisan ide-helper:meta
