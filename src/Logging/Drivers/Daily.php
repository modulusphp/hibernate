<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;

class Daily extends Driver
{
  /**
   * Get log storage
   *
   * @return string
   */
  private function getStorage() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.storage") ?

      Config::get("logging.channels.{$this->getName()}.storage") :
      
      storage_path('logs/')

    );
  }

  /**
   * Get log name
   *
   * @return string
   */
  private function getLogName() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.name") ?

      Config::get("logging.channels.{$this->getName()}.name") :
      
      'modulus'

    );
  }
}
