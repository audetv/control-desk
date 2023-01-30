init: docker-down-clear docker-pull docker-build docker-up api-init
up: docker-up
down: docker-down
restart: down up
lint: api-lint

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-init: api-composer-install api-permissions

api-permissions:
	docker run --rm -v ${PWD}/api:/app -w /app alpine chmod 777 var

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-lint:
	docker-compose run --rm api-php-cli composer lint

build: build-gateway build-frontend build-api

build-gateway:
	docker --log-level=debug build --pull --file=gateway/docker/production/nginx/Dockerfile --tag=${REGISTRY}/control-desk-gateway:${IMAGE_TAG} gateway/docker

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/control-desk-frontend:${IMAGE_TAG} frontend

build-api:
	docker --log-level=debug build --pull --file=api/docker/production/nginx/Dockerfile --tag=${REGISTRY}/control-desk-api:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/control-desk-api-php-fpm:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/production/php-cli/Dockerfile --tag=${REGISTRY}/control-desk-api-php-cli:${IMAGE_TAG} api

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

push: push-gateway push-frontend push-api

push-gateway:
	docker push ${REGISTRY}/control-desk-gateway:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/control-desk-frontend:${IMAGE_TAG}

push-api:
	docker push ${REGISTRY}/control-desk-api:${IMAGE_TAG}
	docker push ${REGISTRY}/control-desk-api-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY}/control-desk-api-php-cli:${IMAGE_TAG}

deploy:
	ssh ${HOST} -p ${PORT} 'rm -rf control-desk_${BUILD_NUMBER}'
	ssh ${HOST} -p ${PORT} 'mkdir control-desk_${BUILD_NUMBER}'
	scp -P ${PORT} docker-compose-production.yml ${HOST}:control-desk_${BUILD_NUMBER}/docker-compose-production.yml
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=control-desk" >> .env'
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml pull'
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml up --build --remove-orphans -d'
	ssh ${HOST} -p ${PORT} 'rm -f control-desk'
	ssh ${HOST} -p ${PORT} 'ln -sr control-desk_${BUILD_NUMBER} control-desk'

rollback:
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml pull'
	ssh ${HOST} -p ${PORT} 'cd control-desk_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml up --build --remove-orphans -d'
	ssh ${HOST} -p ${PORT} 'rm -f control-desk'
	ssh ${HOST} -p ${PORT} 'ln -sr control-desk_${BUILD_NUMBER} control-desk'
