<?php

namespace Modulus\Hibernate\Cache;

use Modulus\Support\Config;
use Modulus\Hibernate\Exceptions\InvalidCacheDriver;
use Modulus\Hibernate\Exceptions\DriverDoesNotExistException;
use Modulus\Hibernate\Exceptions\DriverAlreadyExistsException;
use Modulus\Hibernate\Exceptions\DriverAlreadyRegisteredException;

class CacheBase
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
    'file' => \Modulus\Hibernate\Cache\Drivers\File::class,
    'redis' => \Modulus\Hibernate\Cache\Drivers\Redis::class
  ];

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $default = Config::get('cache.default');
    $driver  = Config::get("cache.connections.{$default}.driver");

    $this->driver = new self::$supported[$this->getDriver($driver) ?? 'file'];
  }

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
   * Get default cache
   *
   * @return mixed
   */
  public function cache()
  {
    if ($this->driver instanceof Driver) return $this->driver;

    throw new InvalidCacheDriver;
  }
}
