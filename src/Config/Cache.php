<?php

namespace Modulus\Hibernate\Config;

trait Cache
{
  /**
   * Path to file confurations
   *
   * @var string $config
   */
  private $config;

  /**
   * Path to the bootstrap folder
   *
   * @var string $bootstrap
   */
  private $bootstrap;

  /**
   * Re-cache data
   *
   * @var bool $autoCache
   */
  private $autoCache = false;

  /**
   * Get cached configs
   *
   * @return array
   */
  private function get() : array
  {
    if ($this->cacheExists()) {
      return $this->reCache() ? $this->make() : $this->getCache();
    }

    return $this->make();
  }

  /**
   * Check if config needs to be re-cached
   *
   * @return bool
   */
  private function reCache() : bool
  {
    if ($this->autoCache) {
      $bootstrap = $this->bootstrap . '/cache/config.php';

      foreach(glob($this->config . '/*.php') as $config) {
        if (filemtime($config) > filemtime($bootstrap)) {
          unlink($bootstrap);
          return true;
        }
      }
    }

    return false;
  }

  /**
   * Check if the config has been cached
   *
   * @return bool
   */
  private function cacheExists() : bool
  {
    $cached = file_exists($this->bootstrap . '/cache/config.php');

    if ($cached) {
      $cache = require($this->bootstrap . '/cache/config.php');

      return is_array($cache);
    }

    return false;
  }

  /**
   * Get cached config
   *
   * @return array
   */
  private function getCache() : array
  {
    return require($this->bootstrap . '/cache/config.php');
  }

  /**
   * Make config
   *
   * @param array $app
   * @return array $app
   */
  private function make($app = []) : array
  {
    $configs = glob($this->config . '/*.php');

    foreach($configs as $config) {
      $service = require($config);

      if (is_array($service)) {
        $name = basename($config, '.php');
        $app  = array_merge($app, [$name => $service]);
      }
    }

    return $app;
  }

  /**
   * Save configs
   *
   * @param array $configs
   * @return void
   */
  private function save(array $configs)
  {
    $configs = var_export($configs, true);

    file_put_contents(
      $this->bootstrap . '/cache/config.php',
      "<?php

return {$configs};"
    );

    return $configs;
  }
}