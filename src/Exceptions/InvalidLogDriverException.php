<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class InvalidLogDriverException extends Exception
{
  /**
   * Instantiate new invalid log driver exception
   *
   * @return void
   */
  public function __construct()
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = 'Invalid log driver';
  }
}