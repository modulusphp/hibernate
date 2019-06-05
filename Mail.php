<?php

namespace Modulus\Hibernate;

use Modulus\Support\Extendable;
use Modulus\Hibernate\Mail\Single;
use Modulus\Hibernate\Mail\MailProps;

final class Mail
{
  use Single;
  use MailProps;
  use Extendable;

  /**
   * Set default connection
   *
   * @param string $connection
   * @return Mail
   */
  public static function connection(string $connection) : Mail
  {
    if (!config("mail.connections.{$connection}")) throw new Exception('Invalid connection');

    self::getMail()->connection = config("mail.connections.{$connection}");

    return self::getMail();
  }
}
