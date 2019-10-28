<?php

namespace Modulus\Hibernate\Queue;

use Carbon\Carbon;
use Modulus\Hibernate\Queue\Job;
use Symfony\Component\Process\Process;
use Modulus\Hibernate\Queue\ShouldQueue;

class Dispatcher
{
  /**
   * Add queue
   *
   * @param ShouldQueue $queue The dispatchable job
   * @param Carbon|null $delay Set the desired delay for the job
   * @return string
   */
  public static function now(ShouldQueue $queue, ?Carbon $delay = null) : string
  {
    return Job::add($queue, $delay)->queueid;
  }
}
