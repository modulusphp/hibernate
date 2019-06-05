<?php

namespace Modulus\Hibernate\Cache;

use Carbon\Carbon;

interface CacheInterface
{
  /**
   * Set and overwrite cache
   *
   * @param string $key
   * @param mixed $value
   * @param Carbon $expire
   * @return bool
   */
  public static function set(string $key, $value, Carbon $expire);

  /**
   * Cache forever
   *
   * @param string $key
   * @param mixed $value
   * @return bool
   */
  public static function forever(string $key, $value);

  /**
   * Get cached key
   *
   * @param string $key
   * @return mixed
   */
  public static function get(string $key);

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key) : bool;

  /**
   * Remove cached item
   *
   * @param string $key
   * @return bool
   */
  public static function forget(string $key) : bool;

  /**
   * Retrieve and remove
   *
   * @param string $key
   * @return mixed
   */
  public static function pull(string $key);

  /**
   * Clear cache
   *
   * @return void
   */
  public static function flush();
}
