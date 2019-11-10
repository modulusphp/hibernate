<?php

namespace Modulus\Hibernate\Session;

use Modulus\Support\Config;
use Modulus\Hibernate\Exception\InvalidDriverException;

class SessionBase
{
  /**
   * Set default driver
   *
   * @var mixed
   */
  protected $driver;

  /**
   * Singleton
   *
   * @var mixed
   */
  protected static $singleton;

  /**
   * Supported drivers
   *
   * @var array
   */
  protected static $supported = [
    'file' => \Modulus\Hibernate\Session\Drivers\File::class,
    'redis' => \Modulus\Hibernate\Session\Drivers\Redis::class,
  ];

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $default = Config::get('session.default');
    $driver  = Config::get("session.connections.{$default}.driver");

    $this->driver = new self::$supported[$this->getDriver($driver)];

    if (!$this->driver instanceof Driver)
      throw new InvalidDriverException('Invalid session driver');

    $this->driver = $this->driver;
  }

  /**
   * Get cache driver
   *
   * @param string $driver
   * @return mixed
   */
  private function getDriver(string $driver)
  {
    return isset(self::$supported[$driver]) ? $driver : null;
  }

  /**
   * Get session
   *
   * @return \Sesshin\User\Session
   */
  public function session()
  {
    return self::$singleton ?? self::$singleton = $this->driver->get();
  }

  /**
   * Boot session
   *
   * @return void
   */
  public static function boot()
  {
    return (new self)->session();
  }
}
