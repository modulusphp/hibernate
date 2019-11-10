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
}