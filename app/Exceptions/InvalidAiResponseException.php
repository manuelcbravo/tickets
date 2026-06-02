<?php

namespace App\Exceptions;

use RuntimeException;

class InvalidAiResponseException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly array $rawResponse = [],
        public readonly ?string $responseText = null,
    ) {
        parent::__construct($message);
    }
}
