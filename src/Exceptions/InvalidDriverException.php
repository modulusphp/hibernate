<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class InvalidDriverException extends Exception
{
  /**
   * Instantiate a new invalid driver exception
   *
   * @param string $message
   * @return void
   */
  public function __construct(string $message)
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = $message;
  }
}
