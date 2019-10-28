<?php

namespace Modulus\Hibernate\Mail\Directives;

use Exception;
use AtlantisPHP\Medusa\Directive;

class EmailFooter extends Directive
{
  /**
   * Directive name
   *
   * @var string
   */
  protected $name = 'email_footer';

  /**
   * Handle directive
   *
   * @return string
   */
  public function message() : string
  {
    $path = __DIR__ . DS . ".." . DS . "Assets" . DS . "footer.medusa.php";

    if (!file_exists($path)) {
      throw new Exception('Invalid operation');
    }

    return file_get_contents($path);
  }
}
