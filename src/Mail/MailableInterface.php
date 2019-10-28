<?php

namespace Modulus\Hibernate\Mail;

interface MailableInterface
{
  /**
   * Build mailable
   *
   * @return Mailable
   */
  public function build();

  /**
   * Set the default view
   *
   * @param string $view
   * @return Mailable
   */
  public function view(string $view) : Mailable;

  /**
   * Set the email subject
   *
   * @param string $subject
   * @return Mailable
   */
  public function subject(string $subject) : Mailable;

  /**
   * Set email variables
   *
   * @param array $variables
   * @return Mailable
   */
  public function with(array $variables) : Mailable;
}
