<?php

namespace Modulus\Hibernate\Encrypt;

interface AESInterface
{
  /**
   * Encrypt data
   *
   * @param mixed $value
   * @return string
   */
  public static function encrypt($value) : string;

  /**
   * Reverse encryption
   *
   * @param string $value
   * @return mixed
   */
  public static function decrypt($value);
}
