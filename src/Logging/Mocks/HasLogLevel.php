<?php

namespace Modulus\Hibernate\Logging\Mocks;

use Monolog\Logger;
use Modulus\Support\Config;

trait HasLogLevel
{
  /**
   * Get log name
   *
   * @return string
   */
  public function getName() : string
  {
    return $this->default ?? Config::get('logging.default');
  }

  /**
   * Get log level number
   *
   * @return int
   */
  private function getLevelNumber($value) : int
  {
    switch ($value) {
      case 'debug':
        return Logger::DEBUG;
        break;

      case 'info':
        return Logger::INFO;
        break;

      case 'notice':
        return Logger::NOTICE;
        break;

      case 'warning':
        return Logger::WARNING;
        break;

      case 'error':
        return Logger::ERROR;
        break;
      
      case 'critical':
        return Logger::CRITICAL;
        break;

      case 'alert':
        return Logger::ALERT;
        break;

      case 'emergency':
        return Logger::EMERGENCY;
        break;

      default:
        return Logger::DEBUG;
        break;
    }
  }
}
