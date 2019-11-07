<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;

class Single extends Driver
{
  /**
   * Create log file if it doesn't already exists
   *
   * @return void
   */
  public function __construct()
  {
    if (!file_exists($this->getLogFile())) touch($this->getLogFile());
  }

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
