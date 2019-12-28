<?php

namespace Modulus\Hibernate\Config;

class BaseConfig
{
  /**
   * All configurations
   *
   * @var array $all
   */
  public static $all = [];

  /**
   * Temporary config
   *
   * @var array $temp
   */
  public static $temp = [];

  /**
   * Boot application config
   *
   * @param array $config
   * @return void
   */
  public static function boot(array $config)
  {
    if (self::$all !== [] || self::$all !== null)
      self::$all = $config;
  }

  /**
   * Check if setting exists
   *
   * @param string $key
   * @return bool
   */
  public static function has(string $key) : bool
  {
    $expect = explode('.', $key);
    $config = self::$all;

    foreach($expect as $setting) {
      if (!isset($config[$setting])) return false;

      $config = $config[$setting];
    }

    return true;
  }

  /**
   * Get config
   *
   * @param  string $config
   * @return mixed  $service
   */
  public static function get(string $config)
  {
    if (isset(self::$temp[$config])) return self::$temp[$config];

    $expect  = explode('.', $config);
    $service = self::$all;

    foreach($expect as $setting) {
      if (isset($service[$setting])) {
        $service = $service[$setting];
      } else {
        return null;
      }
    }

    return $service;
  }

  /**
   * Set temporary config
   *
   * @param string $name
   * @param mixed $value
   * @return bool
   */
  public static function set(string $name, $value) : bool
  {
    if (isset(self::$temp[$name])) return false;

    return is_array(self::$temp = array_merge(self::$temp, [$name => $value]));
  }

  /**
   * Forget temporary config
   *
   * @param string $config
   * @return bool
   */
  public static function forget(string $config) : bool
  {
    if (array_key_exists($config, self::$temp)) {
      unset(self::$temp[$config]);

      return true;
    }

    return false;
  }
}