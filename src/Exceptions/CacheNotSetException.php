<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class CacheNotSetException extends Exception
{
  /**
   * Throw cache driver exception
   *
   * @return void
   */
  public function __construct()
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = 'Default cache not set';
  }
}
