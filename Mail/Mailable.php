<?php

namespace Modulus\Hibernate\Mail;

class Mailable implements MailableInterface
{
  use Props;
  use Mailer;
  use Response;

  /**
   * Create a new instance of the mailable
   *
   * @return void
   */
  public function __construct()
  {
    $this->_args = func_get_args();
  }
}
