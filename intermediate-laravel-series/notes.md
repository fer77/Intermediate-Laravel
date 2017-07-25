## 1

Applications need to trigger certain tasks at various points in time. Monthly, or daily, or even hourly.  Without being part of the application.

Laravel provides a **scheduler**. `app/Console/Kernel.php`

```php
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
