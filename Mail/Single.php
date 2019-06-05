<?php

namespace Modulus\Hibernate\Mail;

use Modulus\Hibernate\Mail;

trait Single
{
  /**
   * Email instance
   *
   * @var Mail
   */
  public static $instance;

  /**
   * Get Mail instance
   *
   * @return Mail
   */
  public static function getMail() : Mail
  {
    return self::$instance ?? self::$instance = new Mail;
  }
}
