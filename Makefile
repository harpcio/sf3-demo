all:

composer: 
	@docker-compose run --rm symfony composer $(filter-out $@, $(MAKECMDGOALS));

bower: 
	@docker-compose run --rm nodejs bower $(filter-out $@, $(MAKECMDGOALS));

console:
	@docker-compose run --rm symfony bin/console $(filter-out $@, $(MAKECMDGOALS));

%:
	@:
