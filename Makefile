DOCKER_FOLDER = .docker
DOCKER_DIR = cd $(DOCKER_FOLDER) &&
HOST_OWNER = $(shell id -u):$(shell id -g)
FILES_OWNERSHIP = sudo chown -R $(HOST_OWNER) .

default: help

# https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
# https://gist.github.com/prwhite/8168133?permalink_comment_id=4266839#gistcomment-4266839
.PHONY: help
help: ## Display this help screen
	@grep -hP '^\w.*?:.*##.*$$' $(MAKEFILE_LIST) | sort -u | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: files/mod
files/permission:	### Set the executable files in Docker folder permissions to 777
	@echo "Checking files permissions"
	@find $(DOCKER_FOLDER) -maxdepth 1 -type f -exec grep -lE '^#!' {} \; | xargs chmod 777
	@find $(DOCKER_FOLDER) -maxdepth 1 -type f -exec grep -lqE '^#!' {} \; -exec ls -la {} \;
	@echo "Files permissions ok"

.PHONY: files/own
files/own: ### Set again the ownership off all the file to the current user
	@echo "Setting the ownership of all the files to the current user"
	@$(FILES_OWNERSHIP)
	@echo "Ownership set"

# Docker commands

.PHONY: build
build: files/permission	### Build the containers inside the ./docker folder
	@echo "Building the containers"
	$(DOCKER_DIR) docker-compose up -d --build --remove-orphans
	@echo "Containers built"

.PHONY: up
up: files/permission	### Start the containers inside the ./docker folder
	@echo "Starting the containers..."
	@$(DOCKER_DIR) docker-compose up -d --remove-orphans
	@echo "Containers started"

.PHONY: down
down:	### Stop the containers inside the ./docker folder
	@echo "Stopping the containers"
	@$(DOCKER_DIR) docker-compose down --remove-orphans --volumes
	@echo "Containers stopped"

# Composer commands

.PHONY: composer/install
composer/install: up	### Install the composer dependencies
	@echo "Installing the composer dependencies"
	@$(DOCKER_DIR) ./composer install

.PHONY: composer/update
composer/update: up	### Update the composer dependencies
	@echo "Updating the composer dependencies"
	@$(DOCKER_DIR) ./composer update

.PHONY: composer/dump
composer/dump: up	### Dump the composer autoload
	@echo "Dumping the composer autoload"
	@$(DOCKER_DIR) ./composer dump-autoload

# Codestyle commands

.PHONY: cs
cs: up	### Run the code sniffer
	@echo "Running the code sniffer"
	@$(DOCKER_DIR) ./composer cs

.PHONY: cs/fix
cs/fix: up	### Run the code sniffer and fix the errors
	@echo "Running the code sniffer and fix the errors"
	@$(DOCKER_DIR) ./composer cs:fix
	@$(FILES_OWNERSHIP)

# Psalm commands

.PHONY: psalm
psalm: up	### Run the psalm
	@echo "Running the psalm"
	@$(DOCKER_DIR) ./composer psalm

# Codeception commands

.PHONY: codecept/build
codecept/build:	up ### Build the codeception suites
	@echo "Building the codeception suites"
	@$(DOCKER_DIR) ./codecept build
	@$(FILES_OWNERSHIP)

.PHONY: clean
clean: up	### Clean the codeception suites
	@echo "Cleaning the codeception suites"
	@$(DOCKER_DIR) ./codecept clean

.PHONY: unit
unit: up	### Run the unit tests
	@echo "Running the unit tests"
	@$(DOCKER_DIR) ./codecept run unit --debug

.PHONY: integration
integration: up	### Run the integration tests
	@echo "Running the integration tests"
	@$(DOCKER_DIR) ./codecept run integration --debug

.PHONY: functional
functional: up	### Run the functional tests
	@echo "Running the functional tests"
	@$(DOCKER_DIR) ./codecept run functional --debug

.PHONY: acceptance
acceptance: up	### Run the acceptance tests
	@echo "Running the acceptance tests"
	@$(DOCKER_DIR) ./codecept run acceptance

.PHONY: tests
tests: unit integration	### Run unit and integration tests

.PHONY: qa
qa: cs psalm unit integration functional	### Run all the tests

# Infection commands

.PHONY: infection
infection: up	### Run the infection
	@echo "Running the infection"
	@$(DOCKER_DIR) ./composer infection

# Rector commands

.PHONY: rector
rector: up	### Run the rector with dry-run
	@echo "Running the rector in dry-run mode, if you want to apply the refactorings run make rector/fix"
	@$(DOCKER_DIR) ./composer rector

.PHONY: rector/fix
rector/fix: up	### Apply the rector refactorings
	@echo "Running the rector"
	@$(DOCKER_DIR) ./composer rector:fix
	@$(FILES_OWNERSHIP)

# Benchmark commands

.PHONY: bench
bench:	### Run the benchmark in the local machine not in the docker container
	@echo "Running the benchmark"
	@composer bench

# PhpMetrics commands

.PHONY: docker/metrics
docker/metrics:	### Run the phpmetrics
	@echo "Running the phpmetrics"
	@docker run --rm \
         --user $(id -u):$(id -g) \
         --volume `pwd`:/project \
         herloct/phpmetrics --report-html=./tests/_output/report src

# PhpMetrics commands from composer

.PHONY: metrics
metrics: up	### Run the composer/metrics
	@echo "Running the psalm"
	@$(DOCKER_DIR) ./composer metrics

# Generate commands

.PHONY: generate
generate: up	### Run the codeception generate test files in unit and integration suite, use FILE=filename to generate a specific file
	@echo "Start generating the test files"
	@if [ ! -z "$(FILE)" -a ! -f "tests/unit/$(FILE)Test.php" ]; then \
		echo "File does not exists, generating now."; \
		./vendor/bin/codecept generate:test unit $(FILE); \
	else \
		echo "FILE variable empty or file already generated"; \
	fi
	@if [ ! -z "$(FILE)" -a ! -f "tests/integration/$(FILE)Test.php" ]; then \
		echo "File does not exists, generating now."; \
		./vendor/bin/codecept generate:wpunit integration $(FILE); \
	else \
		echo "FILE variable empty or file already generated"; \
	fi
	@$(FILES_OWNERSHIP)
	@echo "Files generated"
