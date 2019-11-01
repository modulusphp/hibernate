<?php

namespace Modulus\Hibernate\Cache;

use Carbon\Carbon;

interface DriverInterface
{
  /**
   * Delete cache file
   *
   * @return bool
   */
  public function delete() : bool;

  /**
   * Remove key from cache file
   *
   * @param string $key
   * @return bool
   */
  public function remove(string $key) : bool;

  /**
   * Assign new item to key
   *
   * @param string $key
   * @param mixed $value
   * @param Carbon $expire
   * @return bool
   */
  public function assign(string $key, $value, ?Carbon $expire = null) : bool;

  /**
   * Retrieve cached value
   *
   * @param string $key
   * @return mixed
   */
  public function retrieve(string $key);

  /**
   * Check if item is cached
   *
   * @param string $key
   * @return bool
   */
  public function present(string $key) : bool;

  /**
   * Get all cached data
   *
   * @return array
   */
  public function all() : array;

  /**
   * Get cache details
   *
   * @return array|null
   */
  public function details();
}
