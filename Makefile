docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

perm:
	sudo chgrp -R www-data storage bootstrap/cache
	sudo chmod -R ug+rwx storage bootstrap/cache

assets-install:
	yarn install

assets-rebuild:
	yarn rebuild node-sass --force

assets-dev:
	yarn run dev

assets-watch:
	yarn run watch