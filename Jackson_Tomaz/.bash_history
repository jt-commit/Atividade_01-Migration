ls
rm -rf atividade_01;
ls
laravel new atividade_01;
laravel new atividade_01
clear
sudo apt update && sudo apt upgrade -y
laravel new atividade_01
composer create-project --prefer-dist laravel/laravel atividade_01
cd atividade_01
php artisan serve
code ..
php artisan migrate
clear
cd..
cd ..
ls
rm -rf atividade_01
laravel new atividade_01
clear
composer create-project --prefer-dist laravel/laravel atividade_01
cd atividade_01
code ..
php artisan server
php artisan serve
php artisan migrate
php artisan make:migration create_authors_table
code ..
php artisan migrate
php artisan make:migration create_categories_table
php artisan migrate
php artisan make:migration create_publishers_table
php artisan migrate
php artisan make:migration create_books_table --create=books
php artisan migrate
php artisan migrate:rollback --step=1
php artisan migrate:refresh
php artisan make:migration add_published_year_to_books_table --table=books
php artisan migrate
php artisan migrate:reset
php artisan migrate
