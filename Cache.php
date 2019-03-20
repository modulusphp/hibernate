<?php

namespace Modulus\Hibernate;

use Modulus\Support\Extendable;
use Modulus\Hibernate\Cache\CacheInterface;
use Modulus\Hibernate\Cache\CacheBase as Base;

class Cache extends Base implements CacheInterface
{
  use Extendable;

  /**
   * Set and overwrite cache
   *
   * @param string $key
   * @param mixed $value
   * @return mixed
   */
  public static function set(string $key, $value)
  {
    return (new Cache)->assign($key, $value, true);
  }

  /**
   * Get cached key
   *
   * @param string $key
   * @return void
   */
  public static function get(string $key)
  {
    return (new Cache)->retrieve($key);
  }

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key) : bool
  {
    if ((new Cache)->retrieve($key) == null) return false;
    return true;
  }

  /**
   * Cache new item if its not already cached
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public static function add(string $key, $value)
  {
    return (new Cache)->assign($key, $value, false);
  }

  /**
   * Remove cached item
   *
   * @param string $key
   * @return void
   */
  public static function forget(string $key)
  {
    return (new Cache)->remove($key);
  }

  /**
   * Retrieve and remove
   *
   * @param string $key
   * @return mixed
   */
  public static function pull(string $key)
  {
    if (Self::has($key)) {
      $value = Self::get($key);
      Self::forget($key);

      return $value;
    }

    return null;
  }

  /**
   * Clear cache
   *
   * @return void
   */
  public static function flush()
  {
    return (new Cache)->delete();
  }
}
