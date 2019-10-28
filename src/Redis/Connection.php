<?php

namespace Modulus\Hibernate\Redis;

use Exception;
use Predis\Client;
use Modulus\Hibernate\Exceptions\UnknownRedisConnectionException;

class Connection
{
  /**
   * Redis client
   *
   * @var Client
   */
  protected $client;

  /**
   * Bool Predis
   *
   * @param array $options
   * @return void
   */
  public function __construct(array $options)
  {
    $this->client = new Client($options);
  }

  /**
   * Set default connection
   *
   * @param string $connection
   * @return Connection
   */
  public static function configure(string $connection = 'default')
  {
    if (!config("redis.connections.{$connection}")) throw new UnknownRedisConnectionException($connection);

    $connection = config("redis.connections.{$connection}");

    return new self($connection);
  }
}