<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Monolog\Handler\StreamHandler;
use Modulus\Hibernate\Logging\Driver;
use Monolog\Handler\HandlerInterface;

class Daily extends Driver
{
  /**
   * Create log file if it doesn't already exists
   *
   * @return void
   */
  public function __construct()
  {
    if (!file_exists($this->getLogFile())) touch($this->getLogFile());
  }

  /**
   * Register handler
   *
   * @return HandlerInterface
   */
  public function handler() : HandlerInterface
  {
    return new StreamHandler($this->getLogFile(), $this->getLogLevel());
  }

  /**
   * Get log file
   *
   * @return string
   */
  private function getLogFile() : string
  {
    $storage = rtrim($this->getStorage(), '/');

    $name    = $this->getLogName();

    return "{$storage}/{$name}-" . date("Y-m-d") . '.log';
  }

  /**
   * Get log storage
   *
   * @return string
   */
  private function getStorage() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.storage") ?

      Config::get("logging.channels.{$this->getName()}.storage") :
      
      storage_path('logs/')

    );
  }

  /**
   * Get log name
   *
   * @return string
   */
  private function getLogName() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.name") ?

      Config::get("logging.channels.{$this->getName()}.name") :
      
      'modulus'

    );
  }
}
