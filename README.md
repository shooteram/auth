```
composer require shooteram/auth
php artisan vendor:publish --provider "shooteram\Auth\ServiceProvider"
php artisan passport:keys
```

Then, define your whitelisted origins in your new config file `config\cors.php`.
