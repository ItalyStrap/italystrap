
.PHONY: up down codeceptbuild unit integration functional acceptance qa
composebuild:
	cd .docker && docker-compose  --env-file ../.env up -d --build

up:
	cd .docker && docker-compose  --env-file ../.env up -d --remove-orphans

down:
	cd .docker && docker-compose  --env-file ../.env down --remove-orphans --volumes

codeceptbuild: up
	.docker/codecept build

clean: up
	.docker/codecept clean

unit: up
	.docker/codecept run unit

integration: up
	.docker/codecept run integration

functional: up
	.docker/codecept run functional --debug

acceptance: up
	.docker/codecept run acceptance

qa: unit integration functional acceptance

cs:
	composer cs

fix:
	composer cs:fix