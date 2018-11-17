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
    $args = debug_backtrace()[3];

    foreach ($args as $key => $value) {
      $this->{$key} = $value;
    }
  }
}
