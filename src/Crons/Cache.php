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
  public static function handle()
  {
    /** @var array|null $cache */

    foreach((new AppCache)->all() as $key => $cache) {
      if ($cache['expire'] !== null && self::shouldRemove($cache['expire'])) {
        AppCache::pull($key);
      }
    }
  }

  /**
   * Check if cache has expired
   *
   * @return bool
   */
  public static function shouldRemove($expire) : bool
  {
    $delay = $expire->startOfMinute();

    $now   = Carbon::now()->startOfMinute();

    return $delay < $now || $delay == $now;
  }
}
