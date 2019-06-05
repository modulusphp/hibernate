<?php

namespace Modulus\Hibernate;

use Carbon\Carbon;
use Modulus\Support\Extendable;
use Modulus\Hibernate\Cache\CacheBase;
use Modulus\Hibernate\Cache\CacheInterface;

final class Cache extends CacheBase implements CacheInterface
{
  use Extendable;

  /**
   * Set and overwrite cache
   *
   * @param string $key
   * @param mixed $value
   * @param Carbon $expire
   * @return bool
   */
  public static function set(string $key, $value, Carbon $expire)
  {
    return (new self)->assign($key, $value, $expire);
  }

  /**
   * Cache forever
   *
   * @param string $key
   * @param mixed $value
   * @return bool
   */
  public static function forever(string $key, $value)
  {
    return (new self)->assign($key, $value, null);
  }

  /**
   * Get cached key
   *
   * @param string $key
   * @return mixed
   */
  public static function get(string $key)
  {
    return (new self)->retrieve($key);
  }

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key) : bool
  {
    return (new self)->present($key);
  }

  /**
   * Remove cached item
   *
   * @param string $key
   * @return bool
   */
  public static function forget(string $key) : bool
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
