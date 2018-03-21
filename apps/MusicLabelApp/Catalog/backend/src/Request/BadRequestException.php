<?php

namespace Masfernandez\MusicLabelApp\Catalog\Infrastructure\Backend\Request;

use Exception;
use Throwable;

final class BadRequestException extends Exception
{
    public function __construct(private array $errors, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
