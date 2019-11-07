<?php

namespace Modulus\Hibernate\Logging;

use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;
use Modulus\Hibernate\Exceptions\InvalidLogDriverException;

class MonologBase
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
    'single' => \Modulus\Hibernate\Logging\Drivers\Single::class,
    'daily' => \Modulus\Hibernate\Logging\Drivers\Daily::class,
    'slack' => \Modulus\Hibernate\Logging\Drivers\Slack::class,
  ];

  /**
   * Get monolog driver
   *
   * @param string $driver
   * @return mixed
   */
  private function getDriver(string $driver)
  {
    return isset(self::$supported[$driver]) ? $driver : null;
  }

  /**
   * Find monolog driver
   *
   * @param string $driver
   * @return mixed
   */
  public static function instance(string $driver)
  {
    return isset(self::$supported[$driver]) ? (new self::$supported[$driver]) : null;
  }
}
