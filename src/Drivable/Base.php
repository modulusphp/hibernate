<?php

namespace Modulus\Hibernate\Drivable;

use Modulus\Hibernate\Exceptions\DriverDoesNotExistException;
use Modulus\Hibernate\Exceptions\DriverAlreadyExistsException;
use Modulus\Hibernate\Exceptions\DriverAlreadyRegisteredException;

class Base
{/**
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
  protected static $supported = [];

  /**
   * Get driver
   *
   * @param string $driver
   * @return mixed
   */
  protected function getDriver(string $driver)
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
}
