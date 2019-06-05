# Modulus Hibernate Component

This component is responsible for Modulus' caching, handing Queues and also extends Eloquent Models.

Install
-------

This package is automatically installed with the Modulus Framework.

```
composer require modulusphp/hibernate
```

Getting Started
---------------

#### Queue Worker (alpha)

The Queue Worker allows you to easily execute tasks in the background. This is done by using Supervisor.

Before you can start creating or executing queues, you need to create a new table that will hold your queues.

Create a migration:

```
php craftsman queue:table
```

If you are using `sqlite` as your default Database driver for Queues (which you should be), you will need to create a new `.queues` file:

```
touch storage/framework/data/.queues
```

See `config/queue.php` and `.env` for more information.

> Don't worry about having your queues stored in a `sqlite` file, all queues are encrypted using the `APP_KEY`.

Run the migration:

```
php craftsman migrate all
```

To create a new Job, simply run the following command:

```
php craftsman craft:job <NameOfTheJob>
```

To execute the newely created job:

```php
dispatch(new \App\Jobs\<NameOfTheJob>);
```

You can also delay a Job by minutes, hours, days, months or even years.
This means, you can execute a job that will only run when you want it to run

```php
dispatch(new \App\Jobs\<NameOfTheJob>, \Carbon\Carbon::now()->addMinutes(10));
```

This Job will run after 10 minutes.

> Note: your supervisor worker must call `craftsman queue:work --process=1`

#### Hibernate Cache

Hibernate Cache is a simple caching system that allows you to store objects, collections, arrays, and other object types. The Hibernate Cache allows you cache forever or specify when a cache should be removed or when it should expire.

```php
cache('user', [
  'name' => 'Donald',
  'age'  => 21,
  'city' => 'East Rand'
]);
```

The code above will keep the user `array` until we decide to remove it.

If we wanted to wanted to keep the user `array` for a month, all we would need to do, is simply add a `Carbon` instance as a 3rd argument:

```php
cache('user', [
  'name' => 'Donald'
  'age'  => 21,
  'city' => 'East Rand'
], \Carbon\Carbon::now()->addMonth());
```

Now, the user `array` will be automatically removed from the cache after a month.

> Note: you must add a cron that executes `craftsman schedule:run` every minute (`* * * * *`)

#### Methods

Here are some methods to help you get started.

 Name              | Helper Method                      | Arguments                                        | Return | Description
-------------------|------------------------------------|--------------------------------------------------|--------|------------
`Cache::set()`     | `cache($key, $value, $expiration)` | `string $key, mixed $value, ?Carbon $expiration` | `bool`  | Set or overwrite cache
`Cache::forever()` | `cache($key, $value)`              | `string $key, mixed $value`                      | `bool`  | Cache forever
`Cache::get()`     | `cache($key)`                      | `string $key`                                    | `mixed` | Get cached key
`Cache::has()`     |                                    | `string $key`                                    | `bool`  | Check if item is cached
`Cache::forget()`  |                                    | `string $key`                                    | `bool`  | Remove cached item
`Cache::pull()`    |                                    | `string $key`                                    | `mixed` | Remove cached item

#### Hibernate Mail (doc incomplete)

Sending emails has never been this easy. Hibernate Mail is a Mailer package built on top of PHPMailer. Creating layouts and sending emails is a lot easier and smoother.

```php
Mail::to('example@something.domain')->queue(new WelcomeEmail('Donald Pakkies'));
```

The code above, will send a welcome email to `"example@something.domain"` in the background.

Security
-------

If you discover any security related issues, please email donaldpakkies@gmail.com instead of using the issue tracker.

License
-------

The MIT License (MIT). Please see [License File](LICENSE) for more information.
