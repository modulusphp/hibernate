<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class HibernateCacheNotSetException extends Exception
{
  /**
   * $message
   *
   * @var string
   */
  protected $message = 'Cache file is not set';

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $position = count(debug_backtrace()) == 10 ? 3 : 2;
    $args     = debug_backtrace()[$position];

    foreach ($args as $key => $value) {
      $this->{$key} = $value;
    }
  }
}
