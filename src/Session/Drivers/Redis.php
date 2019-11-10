<?php

namespace Modulus\Hibernate\Session\Drivers;

use Predis\Client;
use Modulus\Support\Config;
use Sesshin\Store\DoctrineCache;
use Sesshin\Store\StoreInterface;
use Modulus\Hibernate\Session\Driver;
use Doctrine\Common\Cache\PredisCache;

class Redis extends Driver
{
  /**
   * {@inheritDoc}
   */
  public function handler() : StoreInterface
  {
    return new DoctrineCache($this->getRedis());
  }

  /**
   * Get redis cache
   *
   * @return PredisCache
   */
  private function getRedis()
  {
    return new PredisCache(new Client($this->getConnectionOptions()));
  }

  /**
   * Get connection options
   *
   * @return array
   */
  private function getConnectionOptions() : array
  {
    return (

      Config::has("redis.connections.{$this->getConnectionName()}") ?

      Config::get("redis.connections.{$this->getConnectionName()}") :

      []

    );
  }

  /**
   * Get store path
   *
   * @return string
   */
  private function getConnectionName() : string
  {
    return (

      Config::has("session.connections.{$this->getName()}.connection") ?

      Config::get("session.connections.{$this->getName()}.connection") :

      'redis'

    );
  }
}
