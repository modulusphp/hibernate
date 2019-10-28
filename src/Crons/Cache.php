<?php

namespace Modulus\Hibernate\Crons;

use Carbon\Carbon;
use Modulus\Hibernate\Cache as AppCache;

class Cache
{
  /**
   * Remove old cache
   *
   * @return void
   */
  public function handle()
  {
    foreach((new AppCache)->all() as $key => $cache) {
      if ($cache['expire'] !== null && $this->shouldRemove($cache['expire'])) {
        AppCache::pull($key);
      }
    }
  }

  /**
   * Check if cache has expired
   *
   * @return bool
   */
  public function shouldRemove($expire) : bool
  {
    $delay = $expire->startOfMinute();

    $now   = Carbon::now()->startOfMinute();

    return $delay < $now || $delay == $now;
  }
}
