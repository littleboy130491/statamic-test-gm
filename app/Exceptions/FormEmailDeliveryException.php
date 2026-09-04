<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Throwable;

class FormEmailDeliveryException extends RuntimeException
{
    private const USER_MESSAGE = 'Pesan Anda sudah tersimpan, tetapi notifikasi email sedang mengalami gangguan. Tim kami akan memeriksanya sesegera mungkin.';

    public function __construct(
        public readonly string $formHandle,
        Throwable $previous,
    ) {
        parent::__construct('Unable to send a Statamic form notification email.', 0, $previous);
    }

    public function render(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => self::USER_MESSAGE,
                'errors' => [self::USER_MESSAGE],
                'error' => ['email_delivery' => self::USER_MESSAGE],
            ], 422);
        }

        return back()
            ->withInput()
            ->withErrors(
                ['email_delivery' => self::USER_MESSAGE],
                'form.'.$this->formHandle,
            );
    }
}
