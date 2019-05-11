```
$ composer require shooteram/auth
$ php artisan vendor:publish --provider "shooteram\Auth\ServiceProvider"
$ php artisan passport:keys
```

Then, define your whitelisted origins in your new config file `config\cors.php`.

You can send a `GET` request to the `/csrf` endpoint to get a `XSRF-TOKEN` cookie which is required to validate forms.
Once you have it, you can use it as your request's `X-XSRF-TOKEN` header.


#### Configuration

To define the required identifier auth login field, you can set your own in your `cors` published config file (`cors.auth.login.username`).

> Use the trait `Laravel\Passport\HasApiTokens` in your auth provider user model (usually `App\User`) class.
