<?php

namespace Modulus\Hibernate\Logging;

use Modulus\Support\Config;
use Monolog\Handler\HandlerInterface;

class Driver
{
  /**
   * Register handler
   *
   * @return mixed
   */
  public function handler() : HandlerInterface
  {
    //
  }

  /**
   * Get application environment
   *
   * @return string
   */
  private function getEnvironment() : string
  {
    return Config::has('app.env') ? Config::get('app.env') : 'local';
  }
}
