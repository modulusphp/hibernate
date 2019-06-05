<?php

namespace Modulus\Hibernate\Mail;

trait Props
{
  /**
   * Email view
   *
   * @var string
   */
  protected $view;

  /**
   * Email subject
   *
   * @var string
   */
  protected $subject;

  /**
   * Email variables
   *
   * @var array
   */
  protected $variables;
}
