<?php

namespace Modulus\Hibernate\Session\Middleware;

use Modulus\Hibernate\Session\SessionBase;

class StartSession
{
  /**
   * Handle middleware
   *
   * @param \Modulus\Http\Request $request
   * @return bool $continue
   */
  public function handle($request, $continue) : bool
  {
    SessionBase::boot();

    return $continue;
  }
}