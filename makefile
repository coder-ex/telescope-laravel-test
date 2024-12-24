RESET=\033[0m
GREEN=\033[92m
YELLOW=\033[1;33m

down:
	@echo "${YELLOW}Down containers...${RESET}"
	@docker-compose --env-file=.env.local -f "../../db-dev/docker-compose.mysql-8.yml" down
	@docker-compose --env-file=.env.local -f "docker-compose.local.yml" down

up:
	@echo "${YELLOW}Up containers...${RESET}"
	@docker-compose --env-file=.env.local -f "docker-compose.local.yml" up -d
	@docker-compose --env-file=.env.local -f "../../db-dev/docker-compose.mysql-8.yml" up -d

build:
	@docker-compose --env-file=.env.local -f "docker-compose.local.yml" up -d --build

build-db-debug:
	@docker-compose --env-file=.env.local -f "../../db-dev/docker-compose.mysql-8.yml" up --build

stop:
	@docker-compose -f "docker-compose.local.yml" stop

start:
	@docker-compose -f "docker-compose.local.yml" start

ps:
	@docker ps -a

kill:
	@docker rm -f $$(docker ps -aq -f status=exited)