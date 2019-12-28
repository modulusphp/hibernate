<?php

namespace Modulus\Hibernate\Console;

use AtlantisPHP\Console\Command as AtlantisCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends AtlantisCommand
{
  /**
   * @var InputInterface $input
   */
  protected $input;

  /**
   * @var OutputInterface $output
   */
  protected $output;

  /**
   * @var Write $write
   */
  protected $write;

  /**
   * @param InputInterface  $input
   * @param OutputInterface $output
   * @return void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->input  = $input;
    $this->output = $output;
    $this->write  = new Write($output);

    return $this->handle();
  }

  /**
   * Handle command
   *
   * @return mixed
   */
  protected function handle()
  {
    //
  }
}