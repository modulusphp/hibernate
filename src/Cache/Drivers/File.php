<?php

namespace Modulus\Hibernate\Cache\Drivers;

use Carbon\Carbon;
use Modulus\Support\Config;
use Modulus\Support\Filesystem;
use Modulus\Hibernate\Encrypt\AES;
use Modulus\Hibernate\Cache\Driver;
use Modulus\Hibernate\Cache\DriverInterface;
use Modulus\Hibernate\Exceptions\CacheNotFoundException;
use Modulus\Hibernate\Exceptions\HibernateCacheNotSetException;

class File extends Driver implements DriverInterface
{
  /**
   * Cache path
   *
   * @var string
   */
  protected $file;

  /**
   * Cache driver
   *
   * @var string
   */
  protected $driver = 'file';

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    if (!Config::has("cache.connections.{$this->driver}.storage"))
      throw new HibernateCacheNotSetException;

    $this->instance(DIRECTORY_SEPARATOR);
  }

  /**
   * Clear the cache
   *
   * @return bool
   */
  public function delete() : bool
  {
    return file_exists($this->file) ? (file_put_contents($this->file, '') ? true : false) : false;
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
   * @return bool
   */
  public function assign(string $key, $value, ?Carbon $expire = null) : bool
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
   * Get all cached data
   *
   * @return array
   */
  public function all() : array
  {
    return (file_exists($this->file) && is_array(AES::decrypt(file_get_contents($this->file)))) ? AES::decrypt(file_get_contents($this->file)) : [];
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
    $cache = Config::get('cache.default');

    $path =  Config::get("cache.connections.{$cache}.storage");

    if (!file_exists($path)) throw new CacheNotFoundException;

    $this->file = $path;
  }
}
