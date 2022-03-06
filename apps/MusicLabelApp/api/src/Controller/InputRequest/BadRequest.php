<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest;

use Exception;
use Throwable;

final class BadRequest extends Exception
{
    public function __construct(private array $errors = [], $message = "", $code = 0, Throwable $previous = null)
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
