<?php

namespace Modulus\Hibernate\Session\Drivers;

use Modulus\Support\Config;
use Sesshin\Store\FileStore;
use Sesshin\Store\StoreInterface;
use Modulus\Hibernate\Session\Driver;

class File extends Driver
{
  /**
   * {@inheritDoc}
   */
  public function handler() : StoreInterface
  {
    return new FileStore($this->getPath());
  }

  /**
   * Get store path
   *
   * @return string
   */
  private function getPath()
  {
    return (

      Config::has("session.connections.{$this->getName()}.files") ?

      Config::get("session.connections.{$this->getName()}.files") :

      storage_path('framework/sessions')

    );
  }
}
