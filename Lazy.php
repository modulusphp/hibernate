<?php

namespace Modulus\Hibernate;

use Countable;
use IteratorAggregate;
use Modulus\Support\Extendable;

final class Lazy implements Countable, IteratorAggregate
{
  use Extendable;

  /**
   * $current_page
   *
   * @var int
   */
  public $current_page;

  /**
   * $data
   *
   * @var collection
   */
  public $data;

  /**
   * $first_page_url
   *
   * @var string
   */
  public $first_page_url;

  /**
   * $prev_page_url
   *
   * @var string
   */
  public $prev_page_url;

  /**
   * $next_page_url
   *
   * @var string
   */
  public $next_page_url;

  /**
   * $last_page_url
   *
   * @var string
   */
  public $last_page_url;

  /**
   * $per_page
   *
   * @var int
   */
  public $per_page;

  /**
   * $total
   *
   * @var int
   */
  public $total;

  /**
   * __construct
   *
   * @param array $info
   * @return void
   */
  public function  __construct(array $info)
  {
    $this->current_page   = $info['current_page'];
    $this->first_page_url = $info['first_page_url'];
    $this->prev_page_url  = $info['prev_page_url'];
    $this->next_page_url  = $info['next_page_url'];
    $this->last_page_url  = $info['last_page_url'];
    $this->per_page       = $info['per_page'];
    $this->total          = $info['total'];
    $this->data           = $info['data'];
  }

  /**
   * Get total count of data (results)
   *
   * @return int
   */
  public function count() : int
  {
    return count($this->data);
  }

  /**
   * Iterate through the data (result)
   *
   * @return null|object
   */
  public function getIterator() : ?object
  {
    return $this->data;
  }

  /**
   * toArray
   *
   * @return array
   */
  public function toArray()
  {
    return [
      'current_page' => $this->current_page,
      'data' => $this->data,
      'first_page_url' => $this->first_page_url,
      'prev_page_url' => $this->prev_page_url,
      'next_page_url' => $this->next_page_url,
      'last_page_url' => $this->last_page_url,
      'per_page' => $this->per_page,
      'total' => $this->total
    ];
  }
}
