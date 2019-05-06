<?php

namespace Modulus\Hibernate\Queue\Commands;

use Closure;
use Modulus\Hibernate\Queue\Job;
use Symfony\Component\Process\Process;

trait Worker
{
  /**
   * Get all unprocessed jobs, and dispatch them
   *
   * @param int $limit
   * @param int|null $timeout
   * @return void
   */
  private function start(int $limit, ?int $timeout = null)
  {
    /**
     * Get the craftsman cli tool
     */
    $craftsman = $this->getCraftsman();

    /**
     * Work!
     */
    Job::limit($limit)->select('queueid', 'processed', 'tries')->get()->map(function($job) use ($limit, $craftsman, $timeout) {

      if (!$job->hasBeenProcessed()) {
        /**
         * Dispatch job
         */
        (new Process("php {$craftsman} queue:dispatch --id={$job->queueid} >> /dev/null 2>&1"))
                ->setTimeout($timeout)
                ->run();
      }

      $job->hasBeenProcessed() ? $this->stash($job->queueid) : null;

    });
  }
}
