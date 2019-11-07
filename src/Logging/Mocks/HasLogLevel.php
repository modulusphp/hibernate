<?php

namespace Modulus\Hibernate\Logging\Mocks;

use Modulus\Support\Config;

trait HasLogLevel
{
  /**
   * Get log name
   *
   * @return string
   */
  public function getName() : string
  {
    return $this->default ?? Config::get('logging.default');
  }
}
