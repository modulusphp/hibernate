<?php

namespace Modulus\Hibernate\Logging\Mocks;

trait HasFormatting
{
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
