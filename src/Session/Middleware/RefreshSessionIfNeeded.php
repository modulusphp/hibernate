<?php

namespace Modulus\Hibernate\Session\Middleware;

use Modulus\Hibernate\Session;

class RefreshSessionIfNeeded
{
  /**
   * Handle an incoming request.
   *
   * @param \Modulus\Http\Request $request
   * @param bool $continue
   * @return bool $continue
   */
  public function handle($request, $continue) : bool
  {
    if (
      $this->isExpired()
    ) {
      $this->logoutIfLoggedin();

      $this->destroy();
  
      $this->create();
    }

    return $continue;
  }

  /**
   * Check if session has expired
   *
   * @return bool
   */
  protected function isExpired() : bool
  {
    return Session::instance()->isExpired();
  }

  /**
   * Close session
   *
   * @return RefreshSessionIfNeeded
   */
  protected function destroy() : RefreshSessionIfNeeded
  {
    Session::instance()->destroy();

    return $this;
  }

  /**
   * Log user out if the user is logged in
   *
   * @return null|bool
   */
  protected function logoutIfLoggedin() : ?bool
  {
    return Session::isLogged() ? Session::logout() : false;
  }

  /**
   * Create session
   *
   * @return RefreshSessionIfNeeded
   */
  protected function create() : RefreshSessionIfNeeded
  {
    Session::instance()->create();

    return $this;
  }
}
