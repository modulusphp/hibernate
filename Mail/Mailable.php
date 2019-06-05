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

  /**
   * Build mailable
   *
   * @return Mailable
   */
  public function build()
  {
    return $this;
  }

  /**
   * Set the default view
   *
   * @param string $view
   * @return Mailable
   */
  public function view(string $view) : Mailable
  {
    $this->view = $view;

    return $this;
  }

  /**
   * Set the email subject
   *
   * @param string $subject
   * @return Mailable
   */
  public function subject(string $subject) : Mailable
  {
    $this->subject = $subject;

    return $this;
  }
}
