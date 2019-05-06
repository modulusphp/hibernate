<?php

namespace Modulus\Hibernate\Encrypt;

class AES extends AESBase implements AESInterface
{
  /**
   * Encrypt data
   *
   * @param mixed $value
   * @return string
   */
  public static function encrypt($value) : string
  {
    return Parent::encrypt(serialize($value));
  }

  /**
   * Reverse encryption
   *
   * @param string $value
   * @return mixed
   */
  public static function decrypt($value)
  {
    return is_string($value) ? Parent::decrypt($value) : $value;
  }
}
