<?php

namespace Modulus\Hibernate;

use Modulus\Hibernate\Config\BaseConfig;

class Config
{
  /**
   * Check if setting exists
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key): bool
  {
    return BaseConfig::has($key);
  }

  /**
   * Get config
   *
   * @param  string $config
   * @return mixed  $service
   */
  public static function get(string $config)
  {
    return BaseConfig::get($config);
  }

  /**
   * Set temporary config
   *
   * @param string $name
   * @param mixed $value
   * @return bool
   */
  public static function set(string $name, $value): bool
  {
    return BaseConfig::set($name, $value);
  }

  /**
   * Forget temporary config
   *
   * @param string $config
   * @return bool
   */
  public static function forget(string $config): bool
  {
    return BaseConfig::forget($config);
  }
}
