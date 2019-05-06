<?php

namespace Modulus\Hibernate\Queue\Exceptions;

use Exception;
use ReflectionClass;
use Modulus\Hibernate\Queue\ShouldQueue;

class InvalidJobException extends Exception
{
  /**
   * Create new Queue
   *
   * @param Instance $instance
   */
  public function __construct($instance)
  {
    $this->message = (new ReflectionClass($instance))->name . ' does not extend ' . ShouldQueue::class;
  }
}
