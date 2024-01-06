### Test Application

This test application uses the latest version of Laravel _(10.10)_ with Laravel Jetstream installed for ease of use with Authentication and installation of VueJS.

I have also used a simple SQLite database from my env `DB_CONNECTION=sqlite`

Once the repo is cloned

Run
```php
composer install && npm install
```

To install Laravel and all NPM dependancies.

Once that is completed you can run:

```php
php artisan darkside:install
```
This will run the migrations, seeders & factorys.

Default login will be located at `http://localhost:8000/login` for example, unless you are using `Valet` like me, which my project is located in my code dir and I can access via `http://darkside.test/login`.

Once all this is done a simple `npm run dev` to start the _Vite_ server will run the application, allowing you to login.

Details to login are as follows:

```
Email: demo@demo.com
Password: password1
```
