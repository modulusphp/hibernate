<?php

namespace Modulus\Hibernate\Queue\Commands;

use Closure;
use ReflectionClass;
use Modulus\Hibernate\Queue\Job;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Output\OutputInterface;

trait Listener
{
  /**
   * Exit statis
   *
   * @var boolean
   */
  protected $status = true;

  /**
   * Get all unprocessed jobs, and dispatch them
   *
   * @param integer $limit
   * @param integer|null $timeout
   * @param OutputInterface $output
   * @return void
   */
  private function start(int $limit, ?int $timeout = null, OutputInterface $output)
  {
    $craftsman = $this->getCraftsman();
    $self      = $this;

    /**
     * Listen!
     */
    Job::limit($limit)->select('queue', 'queueid', 'processed', 'tries')->get()->map(function ($job) use ($limit, $craftsman, $timeout, $self, $output) {

      if ($job->shouldRun() && !$job->hasBeenProcessed()) {
        /**
         * Get fully qualified class name
         */
        $queue = (new ReflectionClass($job->queue->class))->name;

        $output->writeln("<info>Processing:</info>\033[94m \\{$queue} \033[94m");

        /**
         * Dispatch job
         */
        (new Process("php {$craftsman} queue:dispatch --id={$job->queueid}"))
                ->setTty(false)
                ->setTimeout($timeout)
                ->run(function($line) use ($job, $self) {
                  $self->passed = $line !== 'out' ?: false;
                });

        $output->writeln($this->passed ? "<info>Processed:</info>\033[94m \\{$queue} \033[94m" : "<error>Failed: \\{$queue}</error>");
        ($job->hasBeenProcessed() ? $self->status = false : true);
      }

      $job->hasBeenProcessed() ? $this->stash($job->queueid) : null;

    });
  }
}
