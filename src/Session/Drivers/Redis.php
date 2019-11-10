<?php

namespace Modulus\Hibernate\Session\Drivers;

use Modulus\Support\Config;
use Modulus\Hibernate\Session\Driver;

class Redis extends Driver
{
  /**
   * Get store path
   *
   * @return string
   */
  private function getConnectionName() : string
  {
    return (

      Config::has("session.connections.{$this->getName()}.connection") ?

      Config::get("session.connections.{$this->getName()}.connection") :

      'redis'

    );
  }
}
