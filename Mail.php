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
   * @throws Exception
   * @return Mail
   */
  public static function connection(string $connection) : Mail
  {
    if (!config("mail.connections.{$connection}")) throw new Exception('Invalid connection');

    self::getMail()->connection = config("mail.connections.{$connection}");

    return self::getMail();
  }

  /**
   * Set recipient(s)
   *
   * @param string|array $email
   * @return Mail
   */
  public static function to($email) : Mail
  {
    $email = $email instanceof Model && ($email->email || $email->email_address) ? ($email->email ?? $email->email_address) : $email;

    self::getMail()->recipients = is_array($email) ? $email : (is_string($email) ? [$email] : []);

    return self::getMail();
  }

  /**
   * Set recipient(s) (cc)
   *
   * @param string|array $email
   * @return Mail
   */
  public static function cc($email) : Mail
  {
    self::getMail()->cc = is_array($email) ? $email : (is_string($email) ? [$email] : []);

    return self::getMail();
  }

  /**
   * Set recipient(s) (bcc)
   *
   * @param string|array $email
   * @return Mail
   */
  public static function bcc($email) : Mail
  {
    self::getMail()->bcc = is_array($email) ? $email : (is_string($email) ? [$email] : []);

    return self::getMail();
  }

  /**
   * Set reply to email
   *
   * @param string $email
   * @return Mail
   */
  public static function replyTo(string $email) : Mail
  {
    self::getMail()->reply_to = $email;

    return self::getMail();
  }
}
