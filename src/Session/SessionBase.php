<?php

namespace Modulus\Hibernate\Session;

class SessionBase
{
  /**
   * Supported drivers
   *
   * @var array
   */
  protected static $supported = [
    'file' => \Modulus\Hibernate\Session\Drivers\File::class,
    'redis' => \Modulus\Hibernate\Session\Drivers\Redis::class,
  ];
}