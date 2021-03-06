<?php

namespace Modulus\Hibernate\Session;

use Sesshin\Id\Handler as HandlerStore;
use Sesshin\Id\Store\Cookie as CookieStore;
use Modulus\Hibernate\Session\Mocks\Handler as MockHandler;

class Handler extends HandlerStore
{
  use MockHandler;

  /**
   * {@inheritDoc}
   */
  private $idStore;

  /**
   * {@inheritDoc}
   */
  public function getIdStore()
  {
    if (!$this->idStore) {
      $this->idStore = $this->createStore();
    }

    return $this->idStore;
  }

  /**
   * Create store
   *
   * @return CookieStore
   */
  private function createStore()
  {
    return new CookieStore(

      $this->getName(),

      $this->getPath(),

      $this->getDomain(),

      $this->getSecure(),

      $this->getHttpOnly()

    );
  }
}
