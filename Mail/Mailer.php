<?php

namespace Modulus\Hibernate\Mail;

use Exception;
use Modulus\Hibernate\Mail;
use PHPMailer\PHPMailer\PHPMailer;

trait Mailer
{
  /**
   * Get PHPMailer instance
   *
   * @param array $connection
   * @param bool $shouldDebug
   * @return PHPMailer
   */
  public function getMailer(array $connection, bool $shouldDebug) : PHPMailer
  {
    $mailer = new PHPMailer;

    $mailer->IsSMTP();
    $mailer->IsHTML(true);

    $mailer->SMTPDebug     = $shouldDebug;
    $mailer->SMTPAuth      = true;
    $mailer->SMTPSecure    = $connection['encryption'];
    $mailer->SMTPKeepAlive = true;
    $mailer->Host          = $connection['host'];
    $mailer->Port          = $connection['port'];
    $mailer->Username      = $connection['username'];
    $mailer->Password      = $connection['password'];
    $mailer->Body          = $this->toView()->compiled;

    return $mailer;
  }

  /**
   * Set from details
   *
   * @param PHPMailer $mailer
   * @param Mail $mail
   * @return void
   */
  private function setFrom(PHPMailer $mailer, Mail $mail) : void
  {
    $mailer->SetFrom(
      $mail->from_email ?? $mail->connection['from']['address'],
      $mail->from_name ?? $mail->connection['from']['name']
    );
  }
}
