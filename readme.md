# Service Chat Example

Modified from [qirolab/Laravel-WebSockets-Chat-Example](https://github.com/qirolab/Laravel-WebSockets-Chat-Example)

## Usage

1. Clone this repository
`git clone git@github.com:Jettapon/laravel-service-chat-realtime.git`
1. `composer install`
1. `php artisan key:generate`
1. `cp .env.example .env` and configure your database in .env file.
1. Run migration to create tables in database.
`php artisan migrate`
1. Final step run websockets server.
`php artisan websockets:serve`,

Now test it in your browser.



