<?php

namespace Modulus\Hibernate\Logging;

use Monolog\Logger;
use Modulus\Support\Config;
use Monolog\Handler\HandlerInterface;
use Modulus\Hibernate\Logging\Mocks\{
  HasLogLevel,
  HasFormatting,
  HasManyHandlers,
};

class Driver
{
  use HasLogLevel;
  use HasFormatting;
  use HasManyHandlers;

  /**
   * Make logger
   *
   * @return Logger
   */
  public function get() : Logger
  {
    $log = new Logger($this->getEnvironment());

    $handler = $this->handler();
    $handler->setFormatter($this->formatter());

    $log->pushHandler($handler);

    return $this->default ? $log : $this->withHandlers($log);
  }

  /**
   * Register handler
   *
   * @return mixed
   */
  public function handler() : HandlerInterface
  {
    //
  }

  /**
   * Get application environment
   *
   * @return string
   */
  private function getEnvironment() : string
  {
    return Config::has('app.env') ? Config::get('app.env') : 'local';
  }
}
