## 1

Applications need to trigger certain tasks at various points in time. Monthly, or daily, or even hourly.  Without being part of the application.

Laravel provides a **scheduler**. `app/Console/Kernel.php`

```php
// Kernel.php
protected function schedule(Schedule $schedule)
{
    // $schedule-> is an artisan command, "php artisan inspire".
    $schedule->command('inspire')
             ->hourly();
    // But can also run regular commands, like terminal commands.
    $schedule->exec("touch foo.txt")->dailyAt('10:30');
}
```

_To email something (report or the like) first it has to be saved somewhere_:

```php
  //...
    $schedule->command('projectName:clear-history')->sendOutputTo('path/to/file')->emailOutputTo('');
  //...
```


Full API can be found in:

 `/vendor/laravel/framework/src/Illuminate/Console/Scheduling/Event.php`

and

`https://laravel.com/docs/5.4/scheduling#introduction`

## 2

> Write code the way you would write it first, then create the methods you'll need.


```php
// Kernel.php
protected function schedule(Schedule $schedule) // Fires an event array on the "$schedule" object.
{
    $schedule->command('inspire')
             ->hourly(); // calling $schedule->command updates an events array.
}

// Schedule.php
public function exec($command, array $parameters = [])
{
    //...

    $this->events[] = $event = new Event($this->mutex, $command);

    //...
}
```

## 3

**Events** An important "thing" that just took place within the application.

**Listener** Handles the _event_.

**Eventing** `.../app/Providers/EventServiceProvider.php` _events_ and _listeners_ are mapped here.

events can be created, with their respective files, from the command line `php artisan event:generate`.  This creates the _Event_ and _Listener_ for us.

```php
//EventServiceProvider.php
protected $listen = [
    'App\Events\Event' => [
        'App\Listeners\EventListener',
        'App\Listeners\AnotherListener' // single responsibility principle.
    ],
];
```

To fire an event:

1. reference your event function (helper function).
2. new up the event object you created
3. pass something that you require.

```php
  Event::fire('NameOfTheEvent', []);
```

or using a helper function:

```php
  $someAction = new App\SomeAction;

  event(new NameOfTheEvent($someAction));
```

The class related to the listener gets instantiated or _resolved_ and a method (`handle()`) in that class is triggered.

```php
  //EventServiceProvider.php
  protected $listen = [
      'App\Events\Event' => [
          'App\Listeners\EventListener',
      ],
  ];

  //SomeEventListener.php
  public function handle(SomeAction $event)
  {
    //...
  }
```

## 4

Basic process of listening and firing an event:

- Listen for an event.
- Update an array of the object with all the listeners.
- When the event is fired all the listeners are fetched and for each one a callback is triggered and a response is returned.

`.../vendor/laravel/framework/src/Illuminate/Events/EventServiceProvider.php`
The EventServiceProvider.php `register` function bootstraps the component into the Laravel application.

```php
// $app, is the Laravel container.

public function register()
{
    $this->app->singleton('events', function ($app) { // sends this to Dispatcher.php
        return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
            return $app->make(QueueFactoryContract::class);
        });
    });
}
```

`.../vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php`
Dispatcher.php updates the listen array.

```php
public function listen($events, $listener)
{
    foreach ((array) $events as $event) {
        if (Str::contains($event, '*')) {
            //...
        } else {
            $this->listeners[$event][] = $this->makeListener($listener);
        }
    }
}
```

Then the event is fired.

## 5

Interfaces/[Contracts] (https://github.com/illuminate/contracts).

Using interfaces to decouple the project makes making changes easy to handle and to make.

```php
Route::get('/', function () {
  // dd(app('Illuminate\Config\Repository')['database']['default']);
  // dd(app('Illuminate\Contracts\Config\Repository')['database']['default']);
  // dd(app('config')['database']['default']);
  // dd(app()['config']['database']['default']);
  // dd(Config::get('database.default'));
});
```

_constructor injection_
```php
//...
class WelcomeController extends Controller
{
  protected $config;
  public function __construct(Repository $config)
  {
    $this->config = $config;
  }
    public function test()
    {
      // constructor injection
      return $this->config->get('database.default');
    }
}
```

_method injection_
```php
//...
public function test(Repository $config)
{
  // method injection
  return $config->get('database.default');
}
```

_facade_
```php
//...
use Config;

class WelcomeController extends Controller
{
    public function test()
    {
      // facade
      return Config::get('database.default');
    }
}
```

_config helper function_
```php
//...
class WelcomeController extends Controller
{
    public function test()
    {
      // config helper function
      return config('database.default');
    }
}
```

## 6

Review this section again a couple of times.
---

To find out how anything works in Laravel, go to the <class>ServiceProvider.php where the method is registered and bootstrapped into the Laravel application.

## 7

Middleware manages and filters incoming requests and protect our routes however needed.

`.../app/Http/Kernel.php`
```php
protected $middleware = [
    \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
];
```
This is for middleware that will be executed for every single request.

`.../app/Http/Kernel.php`
```php
protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
];
```
This is for middleware that you "opt" into, won't fire on each request, but only when opted in.

 Command to make middleware from the command line:

- `php artisan make:middleware <name for the middleware>`
- Then register it in `.../app/Http/Kernel.php` under `$routeMiddleware`.

## 8

When using sqlite for a database in these lessons.

1. add sqlite as default in `.../config/database.php`

2. `touch storage/database.sqlite` for newer version of laravel I think this file's path maybe `database/database.sqlite`

When referencing a middleware we can give it the name of the middleware, but if we need to pass parameters we can pass them like this:

```php
Route::get('test', ['middleware' => 'subscribed:yearly', function() {
  return 'You can only view this page if you are logged in and subscribed to the yearly plan';
}]);

```
