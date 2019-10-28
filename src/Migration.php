<?php

namespace Modulus\Hibernate;

use Modulus\System\DB;
use Modulus\Support\Config;

class Migration
{
  /**
   * Run database migration
   *
   * @param boolean $up
   * @return void
   */
  public function run(bool $up = true) : void
  {
    $this->setTemporaryConnection($this->getDBConnection());

    $up ? $this->up() : $this->down();

    $this->setTemporaryConnection(config('database.default'));
  }

  /**
   * Get database connection
   *
   * @return string
   */
  private function getDBConnection() : string
  {
    $connection = (property_exists($this, 'connection') ? $this->connection : config('database.default'));

    if (array_key_exists($connection, array_merge(config('database.connections'), config('queue.connections')))) {
      return $connection;
    }

    return config('database.default');
  }

  /**
   * Set temporary database connection
   *
   * @param string $connection
   * @return void
   */
  private function setTemporaryConnection(string $connection)
  {
    DB::start($connection);
  }
}
