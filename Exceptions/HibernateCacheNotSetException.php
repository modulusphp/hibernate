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
  protected $message = 'Caching directory is not set. Configure hibernate["cache"]["storage"].';

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $args = debug_backtrace()[2];

    foreach ($args as $key => $value) {
      $this->{$key} = $value;
    }
  }
}
