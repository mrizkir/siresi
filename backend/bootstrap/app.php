<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
*/

$app->configure('app');
$app->configure('permission');
$app->configure('jwt');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware([
  'auth' => App\Http\Middleware\Authenticate::class,
  'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
  'role'=> Spatie\Permission\Middlewares\RoleMiddleware::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(Spatie\Permission\PermissionServiceProvider::class);
$app->register(PHPOpenSourceSaver\JWTAuth\Providers\LumenServiceProvider::class);

/*
|--------------------------------------------------------------------------
| alias
|--------------------------------------------------------------------------
*/
$app->alias('cache', \Illuminate\Cache\CacheManager::class);


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------

*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/api.php';
});

return $app;
