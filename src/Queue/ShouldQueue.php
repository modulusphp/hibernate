<?php

namespace Modulus\Hibernate\Queue;

class ShouldQueue
{
  /**
   * The number of times should queue should be tried
   * before giving up
   *
   * @var integer
   */
  protected $tries = 3;

  /**
   * Persist queue
   *
   * @return void
   */
  public function handle()
  {
    //
  }

  /**
   * Get queue tries
   *
   * @return integer
   */
  public function getTries() : int
  {
    return $this->tries;
  }
}
