.PHONY: dockerdir composeupbuild composeup composedown build unit integration functional acceptance qa
dockerdir=cd .docker

composeupbuild:
	cd .docker && docker-compose  --env-file ../.env up -d --build

composeup:
	cd .docker && docker-compose  --env-file ../.env up -d --remove-orphans

composedown:
	cd .docker && docker-compose  --env-file ../.env down --remove-orphans --volumes

build: composeup
	cd .docker && ./codecept build

unit: composeup
	cd .docker && ./codecept run unit

integration: composeup
	#cd .docker && ./codecept run integration
	${dockerdir} && ./codecept run integration
functional: composeup
	cd .docker && ./codecept run functional

acceptance: composeup
	cd .docker && ./codecept run acceptance

qa: unit integration functional acceptance