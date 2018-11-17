<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class HibernateBuilderException extends Exception
{
  /**
   * $message
   *
   * @var string
   */
  protected $message = 'Returned value is not a real Eloquent query.';

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $args = debug_backtrace()[1];

    foreach ($args as $key => $value) {
      $this->{$key} = $value;
    }
  }
}
