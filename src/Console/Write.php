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

  /**
   * Writes a message to the output
   *
   * @param string|iterable $messages The message as an iterable of strings or a single string
   * @param bool $newline Whether to add a newline
   * @param int $options A bitmask of options (one of the OUTPUT or VERBOSITY constants), 0 is considered the same as self::OUTPUT_NORMAL | self::VERBOSITY_NORMAL
   * @return mixed
   */
  public function write($messages, bool $newline = false, int $options = 0)
  {
    return $this->output->write($messages, $newline, $options);
  }
}
