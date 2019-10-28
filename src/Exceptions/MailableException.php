<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class MailableException extends Exception
{
  /**
   * Instantiate a new Mailable exception
   *
   * @param string $message
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
