<?php

namespace Modulus\Hibernate\Cache;

use Modulus\Support\Config;
use Modulus\Security\Encrypter;
use Modulus\Support\Filesystem;
use Modulus\Hibernate\Exceptions\CachePermissionException;
use Modulus\Hibernate\Exceptions\HibernateCacheNotSetException;

class CacheBase
{
  /**
   * $file
   *
   * @var string
   */
  protected $file;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    if (!Config::has('hibernate.cache.storage')) {
      throw new HibernateCacheNotSetException;
    }

    $this->instance(DIRECTORY_SEPARATOR);
  }

  /**
   * Prepare the cache
   *
   * @param string $ds
   * @return void
   */
  private function instance($ds)
  {
    $path = Config::get('app.dir') . Config::get('hibernate.cache.storage');

    if (!is_dir($path))
      mkdir($path, 0777, true);

    if (!is_dir($path))
      throw new CachePermissionException;

    $this->file = $path . $ds . '.cache';
  }
}
