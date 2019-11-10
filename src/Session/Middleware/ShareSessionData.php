<?php

namespace Modulus\Hibernate\Session\Middleware;

use Modulus\Hibernate\Session;

class ShareSessionData
{
  /**
   * Check if application has session data
   *
   * @return bool
   */
  private function hasSession() : bool
  {
    return Session::flash()->has('application/with');
  }
}
