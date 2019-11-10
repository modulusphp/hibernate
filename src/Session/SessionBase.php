<?php

namespace Modulus\Hibernate\Session;

class SessionBase
{
  /**
   * Set default driver
   *
   * @var mixed
   */
  protected $driver;

  /**
   * Supported drivers
   *
   * @var array
   */
  protected static $supported = [
    'file' => \Modulus\Hibernate\Session\Drivers\File::class,
    'redis' => \Modulus\Hibernate\Session\Drivers\Redis::class,
  ];
}