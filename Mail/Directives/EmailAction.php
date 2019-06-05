<?php

namespace Modulus\Hibernate\Mail\Directives;

use Exception;
use AtlantisPHP\Medusa\Directive;

class EmailAction extends Directive
{
  /**
   * Directive name
   *
   * @var string
   */
  protected $name = 'email_action';

  /**
   * Handle directive
   *
   * @return string
   */
  public function message($value) : string
  {
    $params = explode(',', $value);

    $path = __DIR__ . DS . ".." . DS . "Assets" . DS . "button.medusa.php";

    if (!file_exists($path) && count($params) !== 3) {
      throw new Exception('Invalid operation.');
    }

    $text  = $this->getValue($params[0]);
    $url   = $this->getValue($params[1]);
    $align = $this->getValue($params[2]);

    return str_replace('[text]', $text, str_replace('[url]', $url, str_replace('[align]', $align, file_get_contents($path))));
  }

  /**
   * Get param value
   *
   * @param string $value
   * @return string
   */
  private function getValue(string $value) : string
  {
    $value = starts_with($value, ' ') ? substr($value, 1, strlen($value)) : $value;
    $value = ends_with($value, ' ') ? substr($value, 0, strlen($value) - 1) : $value;

    if (
      (!starts_with($value, '"') && !ends_with($value, '"')) ||
      (!starts_with($value, "'") && !ends_with($value, '"'))
    ) {
      return $value;
    }

    $value = substr($value, 1, strlen($value));

    return substr($value, 0, strlen($value) - 1);
  }
}
