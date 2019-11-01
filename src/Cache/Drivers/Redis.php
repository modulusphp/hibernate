<?php

namespace Modulus\Hibernate\Cache\Drivers;

use Carbon\Carbon;
use Modulus\Support\Config;
use Modulus\Hibernate\Cache\Driver;
use Modulus\Hibernate\Redis\Connection;
use Modulus\Hibernate\Cache\DriverInterface;

class Redis extends Driver implements DriverInterface
{
  /**
   * Redis client
   *
   * @var Client
   */
  private $redis;

  /**
   * Cache driver
   *
   * @var string
   */
  protected $driver = 'redis';

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();

    $this->redis = Connection::configure(
      Config::get("cache.connections.{$this->driver}.connection")
    );
  }

  /**
   * Get redis client
   *
   * @return Client
   */
  private function client()
  {
    return $this->redis->client();
  }

  /**
   * Delete cache
   *
   * @return bool
   */
  public function delete() : bool
  {
    return $this->client()->flushAll() ? true : false;
  }

  /**
   * Remove key from cache file
   *
   * @param string $key
   * @return bool
   */
  public function remove(string $key) : bool
  {
    return $this->client()->del($key);
  }

  /**
   * Assign new item to key
   *
   * @param string $key
   * @param mixed $value
   * @param Carbon $expire
   * @return bool
   */
  public function assign(string $key, $value, ?Carbon $expire = null) : bool
  {
    $status = $this->client()->set($key, $value)->getPayload() == 'OK' ? true : false;

    if (!$status) return false;

    if ($expire) $this->client()->expire($key, $expire->diffInSeconds());

    return $status;
  }

  /**
   * Retrieve cached value
   *
   * @param string $key
   * @return mixed
   */
  public function retrieve(string $key)
  {
    if ($this->client()->exists($key)) {
      return $this->client()->get($key);
    }

    return null;
  }

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public function present(string $key) : bool
  {
    return (bool)$this->client()->exists($key);
  }

  /**
   * Get all cached data
   *
   * @return array
   */
  public function all() : array
  {
    return [];
  }

  /**
   * Get cache details
   *
   * @return array|null
   */
  public function details()
  {
    return [
      'records' => $this->client()->dbsize(),
      'size' => round($this->client()->dbsize() / 1024, 1),
      'updated_at' => date('Y-m-d h:i:s', strtotime('now'))
    ];
  }
}
