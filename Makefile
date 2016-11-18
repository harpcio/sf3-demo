all:

composer: 
	@docker-compose exec symfony composer $(filter-out $@, $(MAKECMDGOALS));

bower: 
	@docker-compose exec nodejs bower $(filter-out $@, $(MAKECMDGOALS));

console:
	@docker-compose exec symfony bin/console $(filter-out $@, $(MAKECMDGOALS));

%:
	@: