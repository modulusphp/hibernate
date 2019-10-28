<?php

namespace Modulus\Hibernate\Mail;

trait MailProps
{
  /**
   * Dump and die
   *
   * @var bool
   */
  public $dump_die = false;

  /**
   * Debug on send
   *
   * @var bool
   */
  public $debug = false;

  /**
   * Mail connection
   *
   * @var array
   */
  public $connection;

  /**
   * Recipients
   *
   * @var string|array
   */
  public $recipients = [];

  /**
   * Name
   *
   * @var string
   */
  public $from_name;

  /**
   * Email
   *
   * @var string
   */
  public $from_email;

  /**
   * Reply to
   *
   * @var string
   */
  public $reply_to;

  /**
   * Subject
   *
   * @var string
   */
  public $subject;

  /**
   * CC
   *
   * @var array
   */
  public $cc = [];

  /**
   * BCC
   *
   * @var array
   */
  public $bcc = [];

  /**
   * Email attachments
   *
   * @var array
   */
  public $attachments = [];
}
