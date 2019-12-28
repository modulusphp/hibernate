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
}
