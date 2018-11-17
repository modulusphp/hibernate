<?php

namespace Modulus\Hibernate\Cache;

use Modulus\Support\Config;
use Modulus\Security\Encrypter;
use Modulus\Support\Filesystem;
use Modulus\Hibernate\Exceptions\CachePermissionException;
use Modulus\Hibernate\Exceptions\HibernateCacheNotSetException;

class CacheBase
{
  /**
   * $file
   *
   * @var string
   */
  private $file;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    if (!Config::has('hibernate.cache.storage')) {
      throw new HibernateCacheNotSetException;
    }

    $this->instance(DIRECTORY_SEPARATOR);
  }

  /**
   * Remove key from cache file
   *
   * @param string $key
   * @return mixed
   */
  public function remove(string $key)
  {
    $file = $this->file;

    if (file_exists($file)) {
      $data = unserialize($this->decrypt(file_get_contents($file)));

      if (is_array($data) && isset($data[$key])) {
        unset($data[$key]);
        $data = $this->encrypt(serialize($data));
        return file_put_contents($file, $data);
      }
    }

    return false;
  }

  /**
   * Delete cache file
   *
   * @return bool
   */
  public function delete()
  {
    $file = $this->file;

    if (file_exists($file)) return Filesystem::delete($file);

    return false;
  }

  /**
   * Assign new item to key
   *
   * @param string $key
   * @param mixed $value
   * @param bool $overwrite
   * @return mixed
   */
  public function assign(string $key, $value, bool $overwrite = false)
  {
    $file = $this->file;

    if (file_exists($file)) {
      $data = unserialize($this->decrypt(file_get_contents($file)));

      if (is_array($data)) {
        if (isset($data[$key])) {
          if ($overwrite == true) {
            $data[$key] = $value;
            $data = $this->encrypt(serialize($data));
            return file_put_contents($file, $data);
          }
          return false;
        } else {
          $data[$key] = $value;
          $data = $this->encrypt(serialize($data));
          return file_put_contents($file, $data);
        }
      }
    }

    $data = $this->encrypt(serialize([$key => $value]));

    file_put_contents($file, $data);

    return false;
  }

  /**
   * Retrieve cached value
   *
   * @param string $key
   * @return mixed
   */
  public function retrieve(string $key)
  {
    $file = $this->file;

    if (file_exists($file)) {
      $data = unserialize($this->decrypt(file_get_contents($file)));

      if (isset($data[$key])) {
        return $data[$key];
      }
    }

    return null;
  }

  /**
   * Get cache details
   *
   * @return array|null
   */
  public function details()
  {
    $file = $this->file;

    if (file_exists($file)) {
      $data = unserialize($this->decrypt(file_get_contents($file)));

      return [
        'records' => count($data),
        'size' => round(filesize($file) / 1024, 1),
        'updated_at' => date('Y-m-d h:i:s', filemtime($file))
      ];
    }

    return null;
  }

  /**
   * Encrypt cache
   *
   * @param string $data
   * @return string
   */
  private function encrypt(string $data)
  {
    $secret = explode(':', config('app.key'))[1];
    $secret = base64_decode($secret);

    return (new Encrypter($secret))->encrypt($data, 9);
  }

  /**
   * Decrypt cache
   *
   * @param string $data
   * @return string
   */
  private function decrypt(string $data)
  {
    $secret = explode(':', config('app.key'))[1];
    $secret = base64_decode($secret);

    return (new Encrypter($secret))->decrypt($data);
  }

  /**
   * Prepare the cache
   *
   * @param mixed $ds
   * @return void
   */
  private function instance($ds)
  {
    $path = Config::get('app.dir') . Config::get('hibernate.cache.storage');

    if (!is_dir($path))
      mkdir($path, 0777, true);

    if (!is_dir($path))
      throw new CachePermissionException;

    $this->file = $path . $ds . 'hibernate.dat';
  }
}
