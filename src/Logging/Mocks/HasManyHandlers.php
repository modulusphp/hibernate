<?php

namespace Modulus\Hibernate\Logging\Mocks;

trait HasManyHandlers
{
  /**
   * Overwrite default driver
   *
   * @var string|null $default
   */
  public $default = null;

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
