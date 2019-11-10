<?php

namespace Modulus\Hibernate\Session;

use Modulus\Support\Config;
use Sesshin\Store\StoreInterface;

class Driver
{
  /**
   * Register driver
   *
   * @return StoreInterface
   */
  public function handler() : StoreInterface
  {
    //
  }

  /**
   * Get connection name
   *
   * @return string
   */
  public function getName() : string
  {
    return Config::get('session.default');
  }
}
