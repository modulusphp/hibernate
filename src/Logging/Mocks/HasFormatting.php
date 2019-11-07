<?php

namespace Modulus\Hibernate\Logging\Mocks;

use Monolog\Formatter\LineFormatter;

trait HasFormatting
{
  /**
   * Set formatting
   *
   * @return mixed
   */
  public function formatter() : LineFormatter
  {
    return new LineFormatter($this->getOutput(), $this->getDateFormat(), false, true);
  }

  /**
   * Get log output
   *
   * @return string
   */
  public function getOutput() : string
  {
    return "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
  }

  /**
   * Get date format
   *
   * @return string
   */
  public function getDateFormat() : string
  {
    return 'Y-m-d G:i:s';
  }
}
