<?php

namespace Modulus\Hibernate;

use Closure;
use Modulus\Http\Get;
use Modulus\Hibernate\Lazy;
use Illuminate\Database\Eloquent\Builder;
use Modulus\Hibernate\Exceptions\HibernateBuilderException;

trait Model
{
  /**
   * Lazy loading
   *
   * @param int $count
   * @param mixed ?Closure
   * @return void
   */
public static function lazy(int $count, ?Closure $closure = null) : Lazy
{
  $page = Get::has('page') ? Get::key('page') : null;
  $path = isset($_SERVER['REQUEST_URI']) ? ((str_contains($_SERVER['REQUEST_URI'], '?')) ? explode('?', ($_SERVER['REQUEST_URI']))[0] : $_SERVER['REQUEST_URI']) : '';

  if ($page == null) {
    $pattern = explode('/', $path);
    $page = (is_numeric(end($pattern)) ? $page = end($pattern) : 1);
  }

  $skip = ($page * $count) - $count;

  if ($closure !== null) {
    $query = call_user_func_array($closure, [new self]);

    if (!$query instanceof Builder) {
      throw new HibernateBuilderException;
    }
  }

  $get   = isset($query) ? $query->skip($skip)->take($count)->get() : self::skip($skip)->take($count)->get();
  $total = isset($query) ? $query->count() : self::count();
  $next  = ($total - ($page * $count)) > 0 ? '/?page=' . ($page + 1) : null;
  $prev  = $page > 1 ? '/?page=' . ($page - 1) : null;
  $first = ($get->count() < 1) ? null : "/?page=1";
  $last  = '/?page=' . (strpos(($total / $count),'.') ? explode('.', $total / $count)[0] + 1 : ($total / $count));

  $object = [
    'current_page' => (int)$page,
    'data' => $get,
    'first_page_url' => $first,
    'prev_page_url' => $prev,
    'next_page_url' => $next,
    'last_page_url' => $last,
    'per_page' => $count,
    'total' => $total
  ];

  return new Lazy($object);
}

  /**
   * Check if value is taken
   *
   * @param mixed array
   * @return array
   */
  public static function isTaken(?array $data = [])
  {
    if (count($data) == 1) {
      foreach($data as $field => $value) {
        return self::where($field, $value)->first() == null ? false: true;
      }
    }

    $response = array();
    foreach($data as $field => $value) {
      $check = self::where($field, $value)->first();

      $response = array_merge($response, array($field => $check == null ? false : true));
    }

    return $response;
  }
}
