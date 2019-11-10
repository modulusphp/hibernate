# Modulus Hibernate Component

This component is responsible for Modulus' caching, handling Queues and also extends Eloquent Models.

Install
-------

This package is automatically installed with the Modulus Framework.

```
composer require modulusphp/hibernate
```

Getting Started
---------------

#### Session (alpha)

A more secure session handler. Hibernate's session handler is more secure and supports more Store Driver's than Modulus's default Blulight Session handler.

To switch to Hibernate's session handler, go to the `index.php` file in the public directory, and remove `Blulight`.

Then register the following middleware's in the `HttpFoundation` class:

```php
\Modulus\Hibernate\Session\Middleware\StartSession::class,
\Modulus\Hibernate\Session\Middleware\ShareSessionData::class,
```

Once that has been done, head over to the `VerifyCsrfToken` class and extend Hibernate's `VerifyCsrfToken` class:

> Note, this may not work

```php
use Modulus\Hibernate\Session\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
  ...
```

Now, update the `session.php` config file with the following content:

```php
<?php

return [
  'default' => env('SESSION_CONNETION', 'file'),

  'name' => env('SESSION_NAME', 'modulus'),

  'connections' => [
    'file' => [
      'driver' => 'file',
      'files' => storage_path('framework/sessions')
    ],

    'redis' => [
      'driver' => 'redis',
      'connection' => 'session'
    ]
  ]
];
```

And you're done!

> Note, this is still a work in progress, so do not use it in production

#### Logging

Hibernate's logger, is meant to be a replacement of @atlantisphp's `telemonlog` package. Built on top Monolog, you get a more stable and widely supported logging library.

> See the config `logging.php` for more information

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

#### Configuration

Out of the box, Hibernate Cache can use both `redis` and/or `file` based caching. `file` based caching is used as the default caching driver.
You can easily use `redis` as the default caching driver by simply setting `HIBERNATE_CACHE` to `redis` in the `.env`.

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

#### Hibernate Mail

Sending emails has never been this easy. Hibernate Mail is a Mailer package built on top of PHPMailer. Creating layouts and sending emails is a lot easier and smoother.

```php
Mail::to('example@something.domain')->queue(new WelcomeEmail('Donald Pakkies'));
```

The code above, will send a welcome email to `"example@something.domain"` in the background.

##### Getting Started with Hibernate Mailer

You can create a new Email Class Template by running the following command:

```bash
php craftsman craft:mail TestMail
```

Your Email Class Template should look like:

```php
<?php

namespace App\Mail;

use Modulus\Hibernate\Mail\Mailable;

class TestMail extends Mailable
{
  /**
   * Handle mailable
   *
   * @return void
   */
  public function handle()
  {
    //
  }

  /**
   * Build email
   *
   * @return Mailable
   */
  public function build()
  {
    return $this;
  }
}
```

Before you can do anything else, you will need to create a new Email View Template in your views:

```bash
touch resources/views/testemail.medusa.php
```

After that, we can start designing our Email View Template. Here is a quick example:

```twig
{% email_layout %}

{% section('main') %}

  <h3>Hello there</h3>

  <p>This is your first custom Email View Template.</p>

{% endsection %}

{% section('footer') %}

  {% email_footer %}

{% endsection %}
```

The `{% email_layout %}` directive will add all the necessary css styling and html code to make your view look decent.

The `{% email_layout %}` directive includes the `main` and `footer` section.
The `{% email_footer %}` directive will add a copyright text at the bottom of all the emails sent from your application. The `env('APP_NAME')` (name of your application) will be used here.

You can also include action buttons in your Email View Templates. The `{% email_action("title", "url", "alginment") %}` helps you add a button in your views:

```twig
{% email_action("Go to Google", "https://google.com", "left") %}
```

You can set the alginment to "right", "left" or "center".

To make your Email Class Template load the Email View Template you just created, you just need to specify the view from the `build` method:

```php
  /**
   * Build email
   *
   * @return Mailable
   */
  public function build()
  {
    return $this->view('testemail');
  }
```

You can also pass variables from your Email Class Template to your Email View Template using the `with` method:

```php
  /**
   * Build email
   *
   * @return Mailable
   */
  public function build()
  {
    return $this->view('testemail')
                ->with([
                  'name' => 'Donald'
                ]);
  }
```

Then you can access the variables like:

```twig
{% email_layout %}

{% section('main') %}

  <h3>Hello {{ $name }}</h3>

  <p>This is your first custom Email View Template.</p>

{% endsection %}

{% section('footer') %}

  {% email_footer %}

{% endsection %}
```

##### Testing Email Templates

You can easily test your Email Templates by returning an instance of a Email Class Template from a route:

```php
Route::get('/test', function () {
  return new App\Mail\TestMail;
});
```

Security
-------

If you discover any security related issues, please email donaldpakkies@gmail.com instead of using the issue tracker.

License
-------

The MIT License (MIT). Please see [License File](LICENSE) for more information.
