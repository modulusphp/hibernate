<?php

namespace Modulus\Hibernate\Session\Middleware;

use Modulus\Utility\Variable;
use Modulus\Hibernate\Session;

class ShareSessionData
{
  /**
   * Handle middleware
   *
   * @param \Modulus\Http\Request $request
   * @return bool $continue
   */
  public function handle($request, $continue) : bool
  {
    if (
      $this->hasSession()
    ) {
      $this->storeSessionData();

      $this->forgetSessionData();
    }

    return $continue;
  }

  /**
   * Check if application has session data
   *
   * @return bool
   */
  private function hasSession() : bool
  {
    return Session::flash()->has('application/with');
  }

  /**
   * Store data from previous session
   *
   * @return void
   */
  private function storeSessionData()
  {
    Variable::setData(Session::flash()->get('application/with'));
  }

  /**
   * Store data in the session
   *
   * @return void
   */
  private function forgetSessionData()
  {
    Session::forget(['application/with']);
  }
}
