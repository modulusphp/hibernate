<?php

namespace Modulus\Hibernate;

use Sesshin\SessionFlash;
use Sesshin\User\Session as UserSession;
use Modulus\Hibernate\Session\SessionBase;

class Session
{
  /**
   * Get user id
   *
   * @return null|string
   */
  public static function getUserId() : ?string
  {
    return (new SessionBase)->session()->getUserId();
  }

  /**
   * Log user in
   *
   * @param string $userId
   * @return void
   */
  public static function login(string $userId) : void
  {
    (new SessionBase)->session()->login($userId);
  }

  /**
   * Check if user is logged in
   *
   * @return bool
   */
  public static function isLogged() : bool
  {
    return (new SessionBase)->session()->isLogged();
  }

  /**
   * Check if user is guest
   *
   * @return bool
   */
  public static function isGuest() : bool
  {
    return !(new SessionBase)->session()->isLogged();
  }

  /**
   * Log user out
   *
   * @return void
   */
  public static function logout()
  {
    (new SessionBase)->session()->logout();
  }

  /**
   * Put a key / value pair or array of key / value pairs in the session
   *
   * @param string|array $key
   * @param mixed $value
   * @return void
   */
  public static function put($key, $value = null)
  {
    (new SessionBase)->session()->put($key, $value);
  }

  /**
   * Push a value onto a session array
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public static function push(string $key, $value)
  {
    (new SessionBase)->session()->push($key, $value);
  }

  /**
   * Remove one or many items from the session
   *
   * @param array $keys
   * @return void
   */
  public static function forget(array $keys)
  {
    (new SessionBase)->session()->forget($keys);
  }

  /**
   * Get flash
   *
   * @return SessionFlash
   */
  public static function flash() : SessionFlash
  {
    return (new SessionBase)->session()->flash();
  }

  /**
   * Get session instance
   *
   * @return UserSession
   */
  public static function instance() : UserSession
  {
    return (new SessionBase)->session();
  }
}
