<?php

namespace Modulus\Hibernate;

use GO\Scheduler;
use Modulus\Hibernate\Crons\Cache;

class Schedule
{
  /**
   * Run scheduler
   *
   * @param Scheduler $schedule
   * @return void
   */
  public static function handle(Scheduler $schedule)
  {
    $schedule->call(function () {
      (new Cache)->handle();
    })->everyMinute();
  }
}
