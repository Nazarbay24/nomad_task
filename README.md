Запуск

- composer install --ignore-platform-reqs
- ./vendor/bin/sail up
- ./vendor/bin/sail php artisan key:generate
- ./vendor/bin/sail php artisan migrate
- ./vendor/bin/sail php artisan db:seed
- ./vendor/bin/sail php artisan optimize
- ./vendor/bin/sail npm install
- ./vendor/bin/sail npm run dev
