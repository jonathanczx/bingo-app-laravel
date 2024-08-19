# BINGO

## Getting Started
This project uses PHP 8.0 and Laravel 9.
1. Clone the repository

2. Set up environment variables with `.env` file. Point the `NEXT_PUBLIC_BACKEND_URL` to your backend url.
```bash
cp .env.example .env
```

3. Install the project
```bash
composer install
php artisan sail:install
```
When installing Sail, select mysql.

4. Spin up sail docker containers in detached mode
```bash
./vendor/bin/sail up -d
```

5. Run Migrations
```bash
./vendor/bin/sail bash
php artisan migrate
```


4. (Optional) Run Tests in the Sail containers
```bash
composer pest
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
