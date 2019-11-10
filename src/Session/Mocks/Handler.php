<?php

namespace Modulus\Hibernate\Session\Mocks;

use Modulus\Support\Config;

trait Handler
{
  /**
   * Get session name
   *
   * @return string
   */
  private function getName() : string
  {
    return (

      Config::has('session.name') ?

      Config::get('session.name') :

      'modulus'

    );
  }

  /**
   * Get session path
   *
   * @return null|string
   */
  private function getPath() : ?string
  {
    return (

      Config::has('session.path') ?

      Config::get('session.path') :

      null

    );
  }

  /**
   * Get session domain
   *
   * @return null|string
   */
  private function getDomain() : ?string
  {
    return (

      Config::has('session.domain') ?

      Config::get('session.domain') :

      null

    );
  }

  /**
   * Get session secure
   *
   * @return bool
   */
  private function getSecure() : bool
  {
    return (

      Config::has('session.secure') ?

      Config::get('session.secure') :

      false

    );
  }

  /**
   * Get session httpOnly
   *
   * @return bool
   */
  private function getHttpOnly() : bool
  {
    return (

      Config::has('session.http_only') ?

      Config::get('session.http_only') :

      true

    );
  }
}
