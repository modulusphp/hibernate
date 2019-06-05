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
