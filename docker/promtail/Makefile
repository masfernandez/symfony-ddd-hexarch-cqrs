.PHONY : up logs down restart

# Starts the container stack
up:
	docker-compose up -d

logs:
	docker-compose logs -f

# Stopping the container stack
down:
	docker-compose down

# Restarting the container stack
restart: down up