<?php

namespace Modulus\Hibernate\Logging\Mocks;

use Modulus\Hibernate\Logging\Driver;
use Modulus\Hibernate\Logging\MonologBase;

trait HasManyHandlers
{
  /**
   * Overwrite default driver
   *
   * @var string|null $default
   */
  public $default = null;

  /**
   * Get driver instance by driver name
   *
   * @param string $driver
   * @return Driver|null
   */
  private function getDriverInstanceByDriverName(string $driver) : ?Driver
  {
    return MonologBase::instance($driver);
  }

  /**
   * Set default channel
   *
   * @param string $name
   * @return self
   */
  public function setDefault(string $name) : self
  {
    $this->default = $name;

    return $this;
  }
}
