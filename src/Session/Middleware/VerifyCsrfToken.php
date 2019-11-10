<?php

namespace Modulus\Hibernate\Session\Middleware;

use Modulus\Hibernate\Session;
use Modulus\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
  /**
   * Check if token matches
   *
   * @param \Modulus\Http\Request $request
   * @return bool
   */
  protected function tokenMatches($request) : bool
  {
    if (!Session::flash()->has('_session_token')) return false;

    return hash_equals(Session::flash()->get('_session_token'), $this->getCsrfToken($request)) ? true : false;
  }

  /**
   * Check if token has not expired
   *
   * @param \Modulus\Http\Request $request
   * @return bool
   */
  protected function hasNotExpired($request) : bool
  {
    if (!Session::flash()->has('_session_stamp')) return false;

    $this->createUrl($request, 'expire');

    if (in_array($request->path(), $this->canExpire)) return true;

    $time = Session::flash()->get('_session_stamp');
    $time = base64_decode($time);

    $expire = config('auth.expire.session_token');

    if(strtotime($time) < strtotime("-$expire")) {
      $this->hasExpired = true;
      return false;
    }

    return true;
  }
}
