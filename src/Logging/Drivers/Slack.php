<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Monolog\Handler\SlackHandler;
use Modulus\Hibernate\Logging\Driver;
use Monolog\Handler\HandlerInterface;

class Slack extends Driver
{
  /**
   * Register handler
   *
   * @return HandlerInterface
   */
  public function handler() : HandlerInterface
  {
    return new SlackHandler(

      $this->getToken(),

      $this->getChannel(),

      $this->getUsername(),

      true,

      $this->getEmoji(),

      $this->getLogLevel()

    );
  }

  /**
   * Get slack bot token
   *
   * @return string
   */
  private function getToken() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.token") ?

      Config::get("logging.channels.{$this->getName()}.token") :

      ''

    );
  }

  /**
   * Get slack channel
   *
   * @return string
   */
  private function getChannel() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.channel") ?

      Config::get("logging.channels.{$this->getName()}.channel") :

      ''

    );
  }

  /**
   * Get slack username
   *
   * @return string
   */
  private function getUsername() : ?string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.username") ?

      Config::get("logging.channels.{$this->getName()}.username") :

      null

    );
  }

  /**
   * Get slack channel
   *
   * @return string
   */
  private function getEmoji() : ?string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.emoji") ?

      Config::get("logging.channels.{$this->getName()}.emoji") :

      null

    );
  }
}
