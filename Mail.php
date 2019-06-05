<?php

namespace Modulus\Hibernate;

use Modulus\Support\Extendable;
use Modulus\Hibernate\Mail\Single;
use Modulus\Hibernate\Mail\MailProps;

final class Mail
{
  use Single;
  use MailProps;
  use Extendable;
}
