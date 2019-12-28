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
}
