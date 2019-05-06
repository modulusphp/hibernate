<?php

namespace Modulus\Hibernate;

use PDO;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;

class Capsule extends Manager
{
  /**
   * Create a new database capsule manager.
   *
   * @param \Illuminate\Container\Container|null  $container
   * @param string $connection
   * @return void
   */
  public function __construct(Container $container = null, string $connection)
  {
    $this->setupContainer($container ?: new Container);

    // Once we have the container setup, we will setup the default configuration
    // options in the container "config" binding. This will make the database
    // manager work correctly out of the box without extreme configuration.
    $this->setupDefaultConfiguration($connection);

    $this->setupManager();
  }

  /**
   * Setup the default database configuration options.
   *
   * @param string|null $connection
   * @return void
   */
  protected function setupDefaultConfiguration(?string $connection = null)
  {
    $this->container['config']['database.fetch'] = PDO::FETCH_OBJ;

    $this->container['config']['database.default'] = $connection;
  }

  /**
   * Register a connection with the manager.
   *
   * @param array $config
   * @param string $name
   * @return void
   */
  public function addConnection(array $config, $name = 'default')
  {
    $connections = ($this->container['config']['database.connections'] = array_merge(config('database.connections'), config('queue.connections')));

    $connections[$name] = $config;

    $this->container['config']['database.connections'] = $connections;
  }
}
