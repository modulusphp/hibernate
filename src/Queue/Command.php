<?php

namespace Modulus\Hibernate\Queue;

use Modulus\Hibernate\Queue\Job;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait Command
{
  /**
   * The number of jobs that should be processed per minute
   *
   * @param InputInterface $input
   * @return integer
   */
  private function getLimit(InputInterface $input) : int
  {
    return is_numeric($input->getOption('process')) ? $input->getOption('process') : 1000;
  }

  /**
   * When a job should timeout
   *
   * @param InputInterface $input
   * @return int|null
   */
  private function getTimeOut(InputInterface $input)
  {
    return is_numeric($input->getOption('timeout')) ? $input->getOption('timeout') : null;
  }

  /**
   * Get craftsman's location
   *
   * @return string
   */
  private function getCraftsman() : string
  {
    return config('app.dir') . 'craftsman';
  }

  /**
   * Remove failed job
   *
   * @param string $job
   * @return bool
   */
  private function stash(string $queueid) : bool
  {
    return Job::whereQueueId($queueid)->first()->delete();
  }
}
