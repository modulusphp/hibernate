<?php

namespace Modulus\Hibernate\Session\Middleware;

use Modulus\Hibernate\Session;
use Modulus\Framework\Exceptions\TokenMismatchException;

class VerifyCsrfToken
{
  /**
   * The URIs that should be excluded from CSRF verification.
   *
   * @var array
   */
  protected $except = [];

  /**
   * The URIs that should be excluded from expiration verification.
   *
   * @var array
   */
  protected $canExpire = [
    '/logout'
  ];

  /**
   * $hasExpired
   *
   * @var boolean
   */
  protected $hasExpired = false;

  /**
   * Handle middleware
   *
   * @param Request $request
   * @param bool $continue
   * @throws TokenMismatchException
   * @return bool
   */
  public function handle($request, $continue) : bool
  {
    if (
      $this->isReading($request) ||
      $this->shouldIgnore($request) ||
      (
        $this->tokenMatches($request) &&
        $this->hasNotExpired($request)
      )
    ) {
      return $continue;
    }

    throw new TokenMismatchException(
      ($this->hasExpired) ? 'Session has expired' : 'Token mismatch'
    );
  }

  /**
   * Determine if the HTTP request uses a ‘read’ verb.
   *
   * @param \Modulus\Http\Request $request
   * @return bool
   */
  protected function isReading($request) : bool
  {
    return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
  }

  /**
   * Check if request should be ignored
   *
   * @param \Modulus\Http\Request $request
   * @return bool
   */
  protected function shouldIgnore($request) : bool
  {
    /** create url */
    $this->createUrl(
      $request,
      'except'
    );

    return in_array($request->path(), $this->except) ? true : false;
  }

  /**
   * Check if token matches
   *
   * @param \Modulus\Http\Request $request
   * @return bool
   */
  protected function tokenMatches($request) : bool
  {
    if (!Session::flash()->has('_session_token')) return false;

    return hash_equals(Session::flash()->get('_session_token'), $this->getCsrfToken($request)) ? true : false;
  }

  /**
   * Get csrf token
   *
   * @param mixed $request
   */
  private function getCsrfToken($request) : string
  {
    if ($request->has('csrf_token')) {
      return $request->input('csrf_token');
    }

    foreach($request->headers() as $header => $value) {
      if (strtoupper($header) == 'X-CSRF-TOKEN') {
        return $value;
      }
    }

    return '';
  }

  /**
   * Check if token has not expired
   *
   * @param \Modulus\Http\Request $request
   * @return bool
   */
  protected function hasNotExpired($request) : bool
  {
    if (!Session::flash()->has('_session_stamp')) return false;

    $this->createUrl($request, 'expire');

    if (in_array($request->path(), $this->canExpire)) return true;

    $time = Session::flash()->get('_session_stamp');
    $time = base64_decode($time);

    $expire = config('auth.expire.session_token');

    if(strtotime($time) < strtotime("-$expire")) {
      $this->hasExpired = true;
      return false;
    }

    return true;
  }

  /**
   * Create url
   *
   * @param  \Modulus\Http\Request  $request
   * @param  string  $type
   * @return void
   */
  private function createUrl($request, string $type)
  {
    $data = ($type == 'expire') ? $this->canExpire : $this->except;

    foreach($data as $i => $url) {
      if (str_contains($url, '{*}')) {
        $path = explode('/', (substr($request->path(), 0, 1) == '/' ? substr($request->path(), 1) : $request->path()));
        $url = explode('/', (substr($url, 0, 1) == '/' ? substr($url, 1) : $url));

        if (count($path) == count($url)) {
          $current = [];

          foreach($url as $k => $t) {
            if ($t == $path[$k]) {
              $current[] = $t;
            } elseif ($t == '{*}') {
              $current[] = $path[$k];
            }
          }

          $data[$i] = implode('/', $current);
        }
      }
    }

    if ($type == 'expire') {
      $this->canExpire = $data;
    } else {
      $this->except = $data;
    }
  }
}