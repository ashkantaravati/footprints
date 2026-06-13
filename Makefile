.PHONY: install dev test lint format migrate seed build clean
install:
	cd backend && composer install
	cd frontend && npm install

dev:
	cd backend && php artisan serve --host=0.0.0.0 & cd frontend && npm run dev

test:
	cd backend && php artisan test
	cd frontend && npm test

lint:
	cd backend && ./vendor/bin/pint --test && ./vendor/bin/phpstan analyse
	cd frontend && npm run lint

format:
	cd backend && ./vendor/bin/pint
	cd frontend && npm run format

migrate:
	cd backend && php artisan migrate

seed:
	cd backend && php artisan db:seed

build:
	cd frontend && npm run build
	cd android && ./gradlew assembleDebug

clean:
	rm -rf backend/vendor frontend/node_modules frontend/dist android/app/build
