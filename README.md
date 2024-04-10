Запуск

composer install
./vendor/bin/sail up
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan db:seed
./vendor/bin/sail php artisan optimize
