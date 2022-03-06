<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Controller\InputRequest;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class InputDataAbstract
{
    protected array $errors;
    protected bool $isValid;
    private ?Request $request;

    public function __construct(RequestStack $requestStack, LoggerInterface $logger)
    {
        $this->request = $requestStack->getMasterRequest();
        $logger->debug(
            sprintf(
                '%s %s%s?%s',
                $this->request->getMethod(),
                $this->request->getHost(),
                $this->request->getPathInfo(),
                $this->request->getQueryString()
            )
        );
        foreach ($this->request->headers->all() as $header => $value) {
            $value = reset($value);
            $logger->debug("$header: $value");
        }
        $logger->debug($this->request->getContent());
        $violations    = $this->extractAndValidateData(clone $this->request);
        $this->isValid = $violations->count() === 0;
        if ($violations->count() > 0) {
            $this->generateErrors($violations);
            throw new BadRequest($this->errors, "Bad Request", Response::HTTP_BAD_REQUEST);
        }
    }

    abstract protected function extractAndValidateData(Request $request): ConstraintViolationListInterface;

    private function generateErrors(ConstraintViolationListInterface $violations): void
    {
        $this->errors = [];
        foreach ($violations as $violation) {
            $field          = str_replace(['[', ']'], ['', ''], $violation->getPropertyPath());
            $detail         = $violation->getMessage();
            $this->errors[] = [
                'source' => ['pointer' => str_replace('field', $field, '/data/attributes/field')],
                'detail' => $detail
            ];
        }
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return mixed[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
