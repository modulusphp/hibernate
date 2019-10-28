<?php

namespace Modulus\Hibernate\Queue\Commands;

use Modulus\Hibernate\Queue\Job;
use Symfony\Component\Console\Input\InputInterface;

trait Dispatcher
{
  /**
   * Dispatch single job
   *
   * @param InputInterface $input
   * @return void
   */
  private function start(InputInterface $input)
  {
    /**
     * Find job
     */
    $job = Job::firstWhereQueueId($input->getOption('id'));

    /**
     * Handle job if its valid, expected to run and has not
     * been processed then complete it.
     */
    if ($job !== null && $job->shouldRun() && !$job->hasBeenProcessed()) {

      /**
       * Increment processed count
       */
      $job->isRunning();

      /**
       * Handle job
       */
      $job->queue->class->handle();

      /**
       * Complete job
       */
      $job->delete();

    }
  }
}
