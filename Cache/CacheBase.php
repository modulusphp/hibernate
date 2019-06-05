<?php

namespace Modulus\Hibernate\Cache;

use Carbon\Carbon;
use Modulus\Support\Config;
use Modulus\Security\Encrypter;
use Modulus\Support\Filesystem;
use Modulus\Hibernate\Encrypt\AES;
use Modulus\Hibernate\Exceptions\CachePermissionException;
use Modulus\Hibernate\Exceptions\HibernateCacheNotSetException;

class CacheBase
{
  /**
   * $file
   *
   * @var string
   */
  protected $file;

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
   * Delete cache file
   *
   * @return bool
   */
  public function delete()
  {
    return file_exists($this->file) ? Filesystem::delete($this->file) : false;
  }

  /**
   * Remove key from cache file
   *
   * @param string $key
   * @return bool
   */
  public function remove(string $key) : bool
  {
    $file = $this->file;

    if (file_exists($file)) {
      $cache = AES::decrypt(file_get_contents($file));

      if (is_array($cache) && isset($cache[$key])) {
        unset($cache[$key]);

        return file_put_contents($file, AES::encrypt($cache));
      }
    }

    return false;
  }

  /**
   * Assign new item to key
   *
   * @param string $key
   * @param mixed $value
   * @param Carbon $expire
   * @return void
   */
  public function assign(string $key, $value, ?Carbon $expire = null)
  {
    $file = $this->file;

    if (file_exists($file)) {
      $cache = AES::decrypt(file_get_contents($file));

      $cache[$key] = ['data' => $value, 'expire' => $expire];

      return file_put_contents($file, AES::encrypt($cache)) ? true : false;
    }

    return false;
  }

  /**
   * Retrieve cached value
   *
   * @param string $key
   * @return void
   */
  public function retrieve(string $key)
  {
    $file = $this->file;

    if (file_exists($file)) {
      $cache = AES::decrypt(file_get_contents($file));

      return isset($cache[$key]) ? $cache[$key]['data'] : null;
    }

    return null;
  }

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public function present(string $key) : bool
  {
    $file = $this->file;

    if (file_exists($file)) {
      $cache = AES::decrypt(file_get_contents($file));

      return isset($cache[$key]) ? true : false;
    }

    return false;
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
      $cache = AES::decrypt(file_get_contents($file));

      return [
        'records' => count(is_array($cache) ? $cache : []),
        'size' => round(filesize($file) / 1024, 1),
        'updated_at' => date('Y-m-d h:i:s', filemtime($file))
      ];
    }

    return null;
  }

  /**
   * Prepare the cache
   *
   * @param string $ds
   * @return void
   */
  private function instance($ds)
  {
    $path = Config::get('app.dir') . Config::get('hibernate.cache.storage');

    if (!is_dir($path))
      mkdir($path, 0777, true);

    if (!is_dir($path))
      throw new CachePermissionException;

    $this->file = $path . $ds . '.cache';
  }
}
