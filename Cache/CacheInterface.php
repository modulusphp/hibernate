<?php

namespace Modulus\Hibernate\Cache;

interface CacheInterface
{
  /**
   * Set and overwrite cache
   *
   * @param string $key
   * @param mixed $value
   * @return mixed
   */
  public static function set(string $key, $value);

  /**
   * Cache new item if its not already cached
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public static function add(string $key, $value);

  /**
   * Get cached key
   *
   * @param string $key
   * @return void
   */
  public static function get(string $key);

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key);

  /**
   * Remove cached item
   *
   * @param string $key
   * @return void
   */
  public static function forget(string $key);

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
