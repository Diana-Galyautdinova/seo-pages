<?php

namespace App\Exceptions;

use Throwable;

class SeoPageNotFoundException extends \Exception
{
    public function __construct(string $message = "Seo page not found", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
