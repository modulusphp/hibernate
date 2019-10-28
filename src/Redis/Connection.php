<?php

namespace Modulus\Hibernate\Redis;

use Predis\Client;

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
   * @param array $connection
   * @return void
   */
  public function __construct(array $connection)
  {
    $this->client = new Client($connection);
  }
}