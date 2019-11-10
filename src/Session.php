<?php

namespace Modulus\Hibernate;

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
}