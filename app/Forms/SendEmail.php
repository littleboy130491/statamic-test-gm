<?php

namespace App\Forms;

use App\Exceptions\FormEmailDeliveryException;
use Statamic\Forms\SendEmail as StatamicSendEmail;
use Throwable;

class SendEmail extends StatamicSendEmail
{
    public function handle(): void
    {
        try {
            parent::handle();
        } catch (Throwable $exception) {
            throw new FormEmailDeliveryException(
                $this->submission->form()->handle(),
                $exception,
            );
        }
    }
}
