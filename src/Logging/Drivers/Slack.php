<?php

namespace Modulus\Hibernate\Logging\Drivers;

use Modulus\Support\Config;
use Monolog\Handler\SlackHandler;
use Modulus\Hibernate\Logging\Driver;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\SlackWebhookHandler;

class Slack extends Driver
{
  /**
   * Register handler
   *
   * @return HandlerInterface
   */
  public function handler() : HandlerInterface
  {
    return $this->isHook() ? $this->makeWebhook() : $this->makeBot();
  }

  /**
   * Make slackbot using webhook
   *
   * @return SlackWebhookHandler
   */
  private function makeWebhook() : SlackWebhookHandler
  {
    return new SlackWebhookHandler(

      $this->getWebhook(),

      $this->getChannel(),

      $this->getUsername(),

      true,

      $this->getEmoji(),

      false,

      $this->includeContextAndExtra(),

      $this->getLogLevel()

    );
  }

  /**
   * Make slackbot
   *
   * @return SlackHandler
   */
  private function makeBot() : SlackHandler
  {
    return new SlackHandler(

      $this->getToken(),

      $this->getChannel(),

      $this->getUsername(),

      true,

      $this->getEmoji(),

      $this->getLogLevel(),

      true,
      
      false,

      $this->includeContextAndExtra()

    );
  }

  /**
   * Check if configuration uses webhooks
   *
   * @return bool
   */
  private function isHook() : bool
  {
    return !in_array($this->getWebhook(), ['', null]);
  }

  /**
   * Get slack bot token
   *
   * @return string
   */
  private function getWebhook() : string
  {
    return (

      Config::has("logging.channels.{$this->getName()}.webhook") ?

      Config::get("logging.channels.{$this->getName()}.webhook") :

      ''

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

  /**
   * Inlucde context and extra
   *
   * @return bool
   */
  private function includeContextAndExtra() : bool
  {
    return (

      Config::has("logging.channels.{$this->getName()}.context_and_extra") ?

      Config::get("logging.channels.{$this->getName()}.context_and_extra") :

      false

    );
  }
}
