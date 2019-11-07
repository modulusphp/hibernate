<?php

namespace Modulus\Hibernate;

use Modulus\Hibernate\Logging\MonologBase;

class Logger
{
  /**
   * Channel name
   *
   * @var string $channel
   */
  protected static $channel;

  /**
   * @param string $channel
   * @return Logger
   */
  public static function channel(string $channel) : Logger
  {
    Logger::$channel = $channel;

    return (new Logger);
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function debug(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->debug($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function info(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->info($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function notice(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->notice($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function warning(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->warning($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function error(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->error($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function critical(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->critical($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function alert(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->alert($message, $context);

    self::$channel = null;
  }

  /**
   * @param mixed $message
   * @param array $context
   * @return void
   */
  public static function emergency(string $message, array $context = [])
  {
    (new MonologBase(self::$channel))->log()->emergency($message, $context);

    self::$channel = null;
  }
}
