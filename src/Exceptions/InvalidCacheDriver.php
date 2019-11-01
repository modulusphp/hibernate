<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class InvalidCacheDriver extends Exception
{
  /**
   * Instantiate a new Mailable exception
   *
   * @return void
   */
  public function __construct()
  {
    $trace = debug_backtrace()[1];

    foreach ($trace as $key => $value) {
      $this->{$key} = $value;
    }

    $this->message = 'Invalid cache driver';
  }
}
