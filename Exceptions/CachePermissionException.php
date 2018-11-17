<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class CachePermissionException extends Exception
{
  /**
   * $message
   *
   * @var string
   */
  protected $message = "Could not create cache folder. Check your permissions.";

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $position = count(debug_backtrace()) == 10 ? 3 : 4;
    $args = debug_backtrace()[$position];

    foreach ($args as $key => $value) {
      $this->{$key} = $value;
    }
  }
}
