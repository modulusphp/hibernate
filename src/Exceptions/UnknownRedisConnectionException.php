<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class UnknownRedisConnectionException extends Exception
{
  /**
   * Set exception message
   *
   * @param string $connection
   */
  public function __construct(string $connection)
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = "\"{$connection}\" connection is invalid";
  }
}