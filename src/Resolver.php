<?php

namespace Modulus\Hibernate;

use GO\Scheduler;
use Modulus\Upstart\Plugin\Base;
use Modulus\Hibernate\Crons\Cache;

class Resolver extends Base
{
  /**
   * {@inheritDoc}
   */
  protected function boot(): void
  {
    //
  }

  /**
   * {@inheritDoc}
   */
  protected function schedule(Scheduler $schedule) : void
  {
    $schedule->call(function () {
      Cache::handle();
    })->everyMinute();
  }

  /**
   * {@inheritDoc}
   */
  public function getCommands(): ?string
  {
    return __DIR__ . '/Console/Commands';
  }
}
