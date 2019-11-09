<?php

namespace Modulus\Hibernate\Logging\Mocks;

use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\JsonFormatter;

trait HasFormatting
{
  /**
   * Set formatting
   *
   * @return LineFormatter|JsonFormatter
   */
  public function formatter()
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
