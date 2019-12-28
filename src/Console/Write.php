<?php

namespace Modulus\Hibernate\Console;

use Symfony\Component\Console\Output\OutputInterface;

class Write
{
  /**
   * @var OutputInterface $output
   */
  protected $output;

  /**
   * Instantiate the write class
   *
   * @param OutputInterface $output
   * @return void
   */
  public function __construct(OutputInterface $output)
  {
    $this->output = $output;
  }
}
