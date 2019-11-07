<?php

namespace Modulus\Hibernate\Logging;

use Modulus\Support\Config;

class Driver
{
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
