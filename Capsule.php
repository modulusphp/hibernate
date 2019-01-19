<?php

namespace Modulus\Hibernate;

use PDO;
use Illuminate\Database\Capsule\Manager;

class Capsule extends Manager
{
  /**
   * Setup the default database configuration options.
   *
   * @return void
   */
  protected function setupDefaultConfiguration()
  {
    $this->container['config']['database.fetch'] = PDO::FETCH_OBJ;

    $this->container['config']['database.default'] = config('database.default');
  }

  /**
   * Register a connection with the manager.
   *
   * @param  array   $config
   * @param  string  $name
   * @return void
   */
  public function addConnection(array $config, $name = 'default')
  {
    $connections = ($this->container['config']['database.connections'] = config('database.connections'));

    $connections[$name] = $config;

    $this->container['config']['database.connections'] = $connections;
  }
}
