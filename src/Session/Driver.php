<?php

namespace Modulus\Hibernate\Session;

use Sesshin\User\Session;
use Modulus\Support\Config;
use Sesshin\Store\StoreInterface;

class Driver
{
  /**
   * Make session
   *
   * @return Session
   */
  public function get() : Session
  {
    $session = new Session($this->handler());

    $session->setIdHandler(new Handler);

    $session->open(true);

    return $session;
  }

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
