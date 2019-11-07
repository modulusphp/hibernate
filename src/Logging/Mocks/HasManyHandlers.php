<?php

namespace Modulus\Hibernate\Logging\Mocks;

use Monolog\Logger;
use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;
use Modulus\Hibernate\Logging\MonologBase;

trait HasManyHandlers
{
  /**
   * Overwrite default driver
   *
   * @var string|null $default
   */
  public $default = null;

  /**
   * Check if logger can load many handlers
   *
   * @param Logger $log
   * @return Logger
   */
  private function withHandlers(Logger $log) : Logger
  {
    $channels = Config::has('logging.with_handlers') ? Config::get('logging.with_handlers') : [];

    if (is_array($channels))
      return $this->attachHandlers($log, $channels);

    return $log;
  }

  /**
   * Load other handlers
   *
   * @param Logger $log
   * @param array $channels
   * @return Logger $log
   */
  private function attachHandlers(Logger $log, array $channels) : Logger
  {
    foreach($channels as $channel) {
      $driver = $this->getDriverNameByChannel($channel);

      if (
        $driver &&
        $this->getDriverInstanceByDriverName($driver)
      ) {
        $driver  = $this->getDriverInstanceByDriverName($driver)->setDefault($channel);
        $handler = $driver->handler();

        $handler->setFormatter($driver->formatter());

        $log->pushHandler($handler);
      }
    }

    return $log;
  }

  /**
   * Get driver
   *
   * @param string $channel
   * @return string|null
   */
  private function getDriverNameByChannel(string $channel) : ?string
  {
    return (

      Config::has("logging.channels.{$channel}.driver") ?

      Config::get("logging.channels.{$channel}.driver") :

      null

    );
  }

  /**
   * Get driver instance by driver name
   *
   * @param string $driver
   * @return Driver|null
   */
  private function getDriverInstanceByDriverName(string $driver) : ?Driver
  {
    return MonologBase::instance($driver);
  }

  /**
   * Set default channel
   *
   * @param string $name
   * @return self
   */
  public function setDefault(string $name) : self
  {
    $this->default = $name;

    return $this;
  }
}
