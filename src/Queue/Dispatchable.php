<?php

namespace Modulus\Hibernate\Queue;

use Carbon\Carbon;
use Modulus\Hibernate\Queue\Dispatcher;
use Modulus\Hibernate\Queue\ShouldQueue;
use Modulus\Hibernate\Queue\Exceptions\InvalidJobException;

trait Dispatchable
{
  /**
   * Dispatch job
   *
   * @param Carbon|null $delay Set the desired delay for the job
   * @return string
   */
  public function dispatch(?Carbon $delay = null) : string
  {
    if ($this instanceof ShouldQueue) {
      return Dispatcher::now($this, $delay);
    }

    throw new InvalidJobException($this);
  }
}
