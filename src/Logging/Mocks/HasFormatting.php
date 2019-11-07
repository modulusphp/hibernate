<?php

namespace Modulus\Hibernate\Logging\Mocks;

trait HasFormatting
{
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
