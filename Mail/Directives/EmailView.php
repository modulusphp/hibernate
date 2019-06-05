<?php

namespace Modulus\Hibernate\Mail\Directives;

use Exception;
use AtlantisPHP\Medusa\Directive;

class EmailView extends Directive
{
  /**
   * Directive name
   *
   * @var string
   */
  protected $name = 'email_layout';

  /**
   * Handle directive
   *
   * @return string
   */
  public function message() : string
  {
    $path = __DIR__ . DS . ".." . DS . "Assets" . DS . "layout.medusa.php";

    if (!file_exists($path)) {
      throw new Exception('Could not locate email view');
    }

    return file_get_contents($path);
  }
}
