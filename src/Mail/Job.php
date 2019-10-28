<?php

namespace Modulus\Hibernate\Mail;

use Modulus\Hibernate\Mail;
use Modulus\Hibernate\Queue\ShouldQueue;
use Modulus\Hibernate\Queue\Dispatchable;
use Modulus\Hibernate\Queue\QueueInterface;

class Job extends ShouldQueue implements QueueInterface
{
  use Dispatchable;

  /**
   * Mailable instance
   *
   * @var Mailable
   */
  protected $mailable;

  /**
   * Mail instance
   *
   * @var Mail
   */
  protected $mail;

  /**
   * Create a new job instance
   *
   * @param Mailable $mailable
   * @param Mail $mail
   * @return void
   */
  public function __construct(Mailable $mailable, Mail $mail)
  {
    $this->mailable = $mailable;
    $this->mail     = $mail;
  }

  /**
   * Execute job
   *
   * @return bool
   */
  public function handle()
  {
    return $this->mailable->send($this->mail);
  }
}
