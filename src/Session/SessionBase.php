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
   * Singleton
   *
   * @var mixed
   */
  protected static $singleton;

  /**
   * Supported drivers
   *
   * @var array
   */
  protected static $supported = [
    'file' => \Modulus\Hibernate\Session\Drivers\File::class,
    'redis' => \Modulus\Hibernate\Session\Drivers\Redis::class,
  ];

  /**
   * Get cache driver
   *
   * @param string $driver
   * @return mixed
   */
  private function getDriver(string $driver)
  {
    return isset(self::$supported[$driver]) ? $driver : null;
  }
}
