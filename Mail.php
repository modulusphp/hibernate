<?php

namespace Modulus\Hibernate;

use Modulus\Support\Extendable;
use Modulus\Hibernate\Mail\Single;
use Modulus\Hibernate\Mail\Mailable;
use Modulus\Hibernate\Mail\MailProps;
use Modulus\Hibernate\Exceptions\MailableException;

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

  /**
   * Set subject
   *
   * @param string $subject
   * @return Mail
   */
  public static function subject(string $subject) : Mail
  {
    self::getMail()->subject = $subject;

    return self::getMail();
  }

  /**
   * Attach a file
   *
   * @param string $path
   * @param string $name
   * @return Mail
   */
  public static function attachment(string $path, string $name = '') : Mail
  {
    self::getMail()->attachments[] = [
      'file' => $path, 'name' => $name
    ];

    return self::getMail();
  }

  /**
   * Send email
   *
   * @param Mailable $mailable
   * @throws MailableException
   * @return bool
   */
  public function send(Mailable $mailable) : bool
  {
    /**
     * Set the connection
     */
    $this->connection == null ? $this->connection(config('mail.default')) : null;

    /**
     * Set the subject
     */
    $this->subject ? $mailable->subject($this->subject) : null;

    /**
     * Send the email
     */
    $results = $mailable->send($this);

    /**
     * Throw an exception if there was an error
     */
    if ($results !== true) throw new MailableException($results);

    /**
     * Email was successful, return true
     */
    return true;
  }
}
