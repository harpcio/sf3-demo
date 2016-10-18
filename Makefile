
composer: cmd = install --no-scripts
composer:
	@docker-compose run --rm composer $(cmd) 

