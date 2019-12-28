<?php

namespace Modulus\Hibernate\Console\Commands;

use Modulus\Hibernate\Config\Cache;
use Modulus\Hibernate\Console\Command;

class ConfigCache extends Command
{
  use Cache;

  /**
   * The name and signature of the console command.
   *
   * @var string $signature
   */
  protected $signature = 'config:cache';

  /**
   * The descriptions of the console commands.
   *
   * @var array $descriptions
   */
  protected $descriptions = [
    'config:cache' => 'Create a cache file for faster configuration loading'
  ];

  /**
   *  Cached file
   *
   * @var string $cache
   */
  protected $cache;

  /**
   * Cache file is present
   *
   * @var bool $exists
   */
  protected $exists;

  /**
   * {@inheritDoc}
   */
  public function __construct($ds = DIRECTORY_SEPARATOR)
  {
    parent::__construct();

    $this->config    = app()->getRoot('config');
    $this->bootstrap = app()->getRoot('bootstrap');
    $this->cache     = $this->bootstrap . $ds . 'cache' . $ds . 'config.php';
    $this->autoCache = true;
  }

  /**
   * {@inheritDoc}
   */
  protected function handle()
  {
    $this->deleteCache();

    $this->makeCache();
  }

  /**
   * Delete cache if it exists
   *
   * @return void
   */
  private function deleteCache()
  {
    if ($this->cacheExists()) {
      $cleared = unlink($this->cache);

      $this->output->writeln($cleared ? 'Configuration cache cleared!' : 'Configuration cache not cleared!');
    }
  }

  /**
   * Make new cache
   *
   * @return void
   */
  private function makeCache()
  {
    if ($this->cacheExists()) return $this->output->writeln('Configuration not cached!');

    $this->save($this->make());

    $this->output->writeln('Configuration cached successfully!');
  }
}
