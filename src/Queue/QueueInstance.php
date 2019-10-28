<?php

namespace Modulus\Hibernate\Queue;

use Carbon\Carbon;
use Modulus\Hibernate\Encrypt\AES;
use Modulus\Hibernate\Queue\ShouldQueue;

class QueueInstance
{
  /**
   * The dispatchable job
   *
   * @var ShouldQueue
   */
  public $class;

  /**
   * Set the desired delay for the job
   *
   * @var Carbon
   */
  public $delay;

  /**
   * Create a new Queue instance
   *
   * @param string $queue Encrypted queue
   */
  public function __construct(string $queue)
  {
    $decrypted = AES::decrypt($queue);

    $this->class = $decrypted['class'];

    $this->delay = $decrypted['delay'];
  }
}
