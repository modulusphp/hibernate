<?php

namespace Modulus\Hibernate\Exceptions;

use Exception;

class HibernateBuilderException extends Exception
{
  public function __construct()
  {
    $this->message = 'Returned value is not a real Eloquent query.';
  }
}