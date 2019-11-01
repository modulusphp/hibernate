<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class DriverAlreadyExistsException extends Exception
{
  /**
   * Throw cache driver exception
   *
   * @param string $name
   * @return void
   */
  public function __construct(string $name)
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = "A driver with the name \"{$name}\" has already been registered";
  }
}
