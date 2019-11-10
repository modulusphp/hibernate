<?php

namespace Modulus\Hibernate;

use Modulus\Hibernate\Session\SessionBase;

class Session
{
  /**
   * Get user id
   *
   * @return null|string
   */
  public static function getUserId() : ?string
  {
    return (new SessionBase)->session()->getUserId();
  }
}