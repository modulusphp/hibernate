<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Modulus\Hibernate\Logging\Driver;

class Slack extends Driver
{
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
