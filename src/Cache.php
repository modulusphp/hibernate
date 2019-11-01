<?php

namespace Modulus\Hibernate;

use Carbon\Carbon;
use Modulus\Support\Config;
use Modulus\Support\Extendable;
use Modulus\Hibernate\Encrypt\AES;
use Modulus\Hibernate\Cache\CacheBase;
use Modulus\Hibernate\Cache\CacheInterface;

final class Cache extends CacheBase implements CacheInterface
{
  use Extendable;

  /**
   * Is cache encryped
   *
   * @return bool
   */
  private static function isEncrypted() : bool
  {
    return Config::has('cache.encrypt') ? Config::get('cache.encrypt') : true;
  }

  /**
   * Encrypt value
   *
   * @param mixed $value
   * @return string
   */
  private static function encrypt($value)
  {
    return self::isEncrypted() ? AES::encrypt($value) : $value;
  }

  /**
   * Decrypt value
   *
   * @param mixed $value
   * @return string
   */
  private static function decrypt($value)
  {
    return self::isEncrypted() ? AES::decrypt($value) : $value;
  }

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
    return (new self)->cache()->assign(strtolower($key), self::encrypt($value), $expire);
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
    return (new self)->cache()->assign(strtolower($key), self::encrypt($value), null);
  }

  /**
   * Get cached key
   *
   * @param string $key
   * @return mixed
   */
  public static function get(string $key)
  {
    return self::decrypt((new self)->cache()->retrieve(strtolower($key)));
  }

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key) : bool
  {
    return (new self)->cache()->present(strtolower($key));
  }

  /**
   * Remove cached item
   *
   * @param string $key
   * @return bool
   */
  public static function forget(string $key) : bool
  {
    return (new self)->cache()->remove(strtolower($key));
  }

  /**
   * Get all cached data
   *
   * @return array
   */
  public static function all() : array
  {
    return (new self)->cache()->all();
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
    return (new self)->cache()->delete();
  }
}
