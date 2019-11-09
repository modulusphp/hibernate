<?php

namespace Modulus\Hibernate\Logging;

use Monolog\Logger;
use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;
use Modulus\Hibernate\Exceptions\InvalidLogDriverException;
use Modulus\Hibernate\Exceptions\DriverDoesNotExistException;
use Modulus\Hibernate\Exceptions\DriverAlreadyExistsException;
use Modulus\Hibernate\Exceptions\DriverAlreadyRegisteredException;

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
    'slack' => \Modulus\Hibernate\Logging\Drivers\Slack::class
  ];

  /**
   * Init monolog
   *
   * @param null|string $channel
   * @throws InvalidLogDriverException
   * @return void
   */
  public function __construct(string $channel = null)
  {
    $default = $channel ?? Config::get('logging.default');
    $driver  = Config::get("logging.channels.{$default}.driver");

    $this->driver = (new self::$supported[$this->getDriver($driver) ?? 'single']);

    if (!$this->driver instanceof Driver)
      throw new InvalidLogDriverException;

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
   * Register a new driver
   *
   * @param string $name
   * @param string $class
   * @throws DriverAlreadyExistsException
   * @throws DriverDoesNotExistException
   * @throws DriverAlreadyRegisteredException
   * @return bool
   */
  public static function register(string $name, string $class) : bool
  {
    if (isset(self::$supported[$name]))
      throw new DriverAlreadyExistsException($name);

    if (!class_exists($class))
      throw new DriverDoesNotExistException($class);

    if (isset(array_values(self::$supported)[$class])) 
      throw new DriverAlreadyRegisteredException($class);

    self::$supported = array_merge(self::$supported, [
      $name => $class
    ]);

    return true;
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
   * @return Logger
   */
  public function log() : Logger
  {
    return $this->driver;
  }
}
