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
   * Send email
   *
   * @param Mail $mail
   * @param string|null $option
   * @return mixed
   */
  public function send(Mail $mail)
  {
    $mailer = $this->getMailer($mail->connection, $mail->debug);

    $this->prepare($mailer, $mail);

    if ($mailer->Send()) return true;

    return $mailer->ErrorInfo;
  }

  /**
   * Prepare email
   *
   * @param PHPMailer $mailer
   * @param Mail $mail
   */
  private function prepare(PHPMailer $mailer, Mail $mail) : void
  {
    $mailer->Subject = $this->subject;

    $this->setFrom($mailer, $mail);

    $mail->reply_to ? $mailer->addReplyTo($mail->reply_to) : null;

    $this->setRecipients($mailer, $mail);
    $this->setAttachments($mailer, $mail);

    (!$mail->dump_die ?: dd($mailer));
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

  /**
   * Set email recipients
   *
   * @param PHPMailer $mailer
   * @param Mail $mail
   * @return void
   */
  private function setRecipients(PHPMailer $mailer, Mail $mail) : void
  {
    foreach($mail->recipients as $recipient) {
      $mailer->AddAddress($recipient);
    }

    foreach($mail->cc as $recipient) {
      $mailer->addCC($recipient);
    }

    foreach($mail->bcc as $recipient) {
      $mailer->addBCC($recipient);
    }
  }

  /**
   * Set email attachments
   *
   * @param PHPMailer $mailer
   * @param Mail $mail
   * @return void
   */
  private function setAttachments(PHPMailer $mailer, Mail $mail) : void
  {
    foreach($mail->attachments as $attachment) {
      $mailer->addAttachment($attachment['file'], $attachment['name']);
    }
  }
}
