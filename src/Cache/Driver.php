<?php

namespace Modulus\Hibernate\Cache;

use Carbon\Carbon;
use Modulus\Support\Config;
use Modulus\Hibernate\Exceptions\InvalidCacheDriver;
use Modulus\Hibernate\Exceptions\CacheNotSetException;

class Driver
{
  /**
   * Cache driver
   *
   * @var string
   */
  protected $driver = 'file';

  /**
   * Check if the default driver is set
   *
   * @return void
   */
  public function __construct()
  {
    if (!Config::has('cache.default'))
      throw new CacheNotSetException;

    $cache = Config::get('cache.default');

    if (Config::get("cache.connections.{$cache}.driver") !== $this->driver)
      throw new InvalidCacheDriver;
  }

  /**
   * Delete cache
   *
   * @return bool
   */
  public function delete() : bool
  {
    return false;
  }

  /**
   * Remove key from cache
   *
   * @param string $key
   * @return bool
   */
  public function remove(string $key) : bool
  {
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
    //
  }

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public function present(string $key) : bool
  {
    return false;
  }

  /**
   * Get all cached data
   *
   * @return array
   */
  public function all() : array
  {
    return [];
  }

  /**
   * Get cache details
   *
   * @return array|null
   */
  public function details()
  {
    //
  }
}
