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
   * @param array $options
   * @return void
   */
  public function __construct(array $options)
  {
    $this->client = new Client($options);
  }
}