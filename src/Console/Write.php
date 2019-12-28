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

  /**
   * Writes a message to the output and adds a newline at the end
   *
   * @param string|iterable $messages The message as an iterable of strings or a single string
   * @param bool $newline Whether to add a newline
   * @return mixed
   */
  public function line($messages, $options = 0)
  {
    return $this->output->writeln($messages, $options);
  }

  /**
   * Writes a info message to the output and adds a newline at the end
   *
   * @param string|iterable $messages The message as an iterable of strings or a single string
   * @param bool $newline Whether to add a newline
   * @return mixed
   */
  public function info(string $message, $options = 0)
  {
    return $this->output->writeln("<info>{$message}</info>", $options);
  }

  /**
   * Writes a error message to the output and adds a newline at the end
   *
   * @param string|iterable $messages The message as an iterable of strings or a single string
   * @param bool $newline Whether to add a newline
   * @return mixed
   */
  public function error(string $message, $options = 0)
  {
    return $this->output->writeln("<error>{$message}</error>", $options);
  }
}
