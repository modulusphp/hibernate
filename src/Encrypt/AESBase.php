<?php

namespace Modulus\Hibernate\Encrypt;

use ErrorException;

class AESBase
{
  /**
   * $method
   *
   * @var string
   */
  protected $method = 'AES-256-CBC';

  /**
   * $key
   *
   * @var string
   */
  protected $key;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $this->key    = $this->getKey();
    $this->method = $this->getCipher();
  }

  /**
   * Get sha application key
   *
   * @return string
   */
  private function getKey() : string
  {
    return openssl_digest(app()->getKey(), 'SHA256', true);
  }

  /**
   * Get cipher method
   *
   * @return string
   */
  private function getCipher() : string
  {
    return in_array(app()->config['app']['cipher'], openssl_get_cipher_methods()) ? app()->config['app']['cipher'] : $this->method;
  }

  /**
   * iv_bytes
   *
   * @return void
   */
  protected function iv_bytes()
  {
    return openssl_cipher_iv_length($this->method);
  }

  /**
   * Encrypt data
   *
   * @param mixed $value
   * @return string
   */
  public static function encrypt(string $data)
  {
    return (new AESBase)->persistEncryption($data);
  }

  /**
   * Reverse encryption
   *
   * @param string $value
   * @return mixed
   */
  public static function decrypt($data)
  {
    return (new AESBase)->persistDecryption($data);
  }

  /**
   * Persist data encryption
   *
   * @param mixed $data
   * @return string
   */
  public function persistEncryption($data)
  {
    $iv = openssl_random_pseudo_bytes($this->iv_bytes());

    return bin2hex($iv) . openssl_encrypt($data, $this->method, $this->key, 0, $iv);
  }

  /**
   * Persist data decryption
   *
   * @param string $value
   * @return mixed
   */
  public function persistDecryption($data)
  {
    try {
      $iv_strlen = 2 * $this->iv_bytes();

      if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
        list(, $iv, $crypted_string) = $regs;

        return unserialize(openssl_decrypt($crypted_string, $this->method, $this->key, 0, hex2bin($iv)));
      }

      return false;
    } catch (ErrorException $e) {
      return $data;
    }
  }
}
