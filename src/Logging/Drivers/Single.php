<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;

class Single extends Driver
{
  /**
   * Get log file
   *
   * @return string
   */
  private function getLogFile() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.path") ?

      Config::get("logging.channels.{$this->getName()}.path") :
      
      storage_path('logs/modulus.log')

    );
  }
}
