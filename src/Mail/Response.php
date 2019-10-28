<?php

namespace Modulus\Hibernate\Mail;

use Modulus\Utility\View;
use Modulus\Hibernate\Exceptions\ViewNotSetException;

trait Response
{
  /**
   * Instance params
   *
   * @var array
   */
  protected $_args;

  /**
   * Render html
   *
   * @return View
   */
  public function toView() : View
  {
    return $this->render();
  }

  /**
   * Render html
   *
   * @return
   */
  public function render() : View
  {
    call_user_func_array([$this, 'handle'], $this->_args);

    $this->build();

    if (!$this->view) throw new ViewNotSetException('View not specified.');

    /**
     * Return rendered view component
     */
    return View::make($this->view, is_array($this->variables) ? $this->variables : []);
  }
}
