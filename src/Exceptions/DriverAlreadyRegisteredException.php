<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class DriverAlreadyRegisteredException extends Exception
{
  /**
   * Throw cache driver exception
   *
   * @param string $class
   * @return void
   */
  public function __construct(string $class)
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = "Driver \"{$class}\" has already been registered under a different name";
  }
}
