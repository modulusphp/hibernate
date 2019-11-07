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
   * Init monolog
   *
   * @param null|string $channel
   * @return void
   */
  public function __construct(string $channel = null)
  {
    $default = $channel ?? Config::get('logging.default');
    $driver  = Config::get("logging.channels.{$default}.driver");

    $this->driver = (new self::$supported[$this->getDriver($driver) ?? 'single']);

    $this->driver = $channel ? $this->driver->setDefault($channel)->get() : $this->driver->get();
  }

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

  /**
   * Get log
   *
   * @throws InvalidLogDriverException
   * @return Driver
   */
  public function log()
  {
    if ($this->driver instanceof Driver) return $this->driver;

    throw new InvalidLogDriverException;
  }
}
