<?php

namespace Modulus\Hibernate\Queue;

interface QueueInterface
{
  /**
   * Persist queue
   *
   * @return void
   */
  public function handle();

  /**
    * Get queue tries
    *
    * @return integer
    */
  public function getTries() : int;
}
