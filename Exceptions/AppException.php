<?php

namespace AmsApp\Exceptions;
use Exception;

class AppException extends Exception implements CommonException
{
    private array $context;

    public function __construct(string $message, int $code = 0, array $context = [], ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * Get additional context for the exception.
     *
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Immediately throw the current exception instance.
     *
     * @throws AppException
     */
    public function throwNow(): void
    {
        throw $this; // Throw the current instance of the exception
    }



}