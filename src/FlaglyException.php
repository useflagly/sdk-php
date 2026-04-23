<?php

declare(strict_types=1);

namespace UseFlagly;

use RuntimeException;

/**
 * Thrown when the UseFlagly API returns an HTTP error response.
 */
class FlaglyException extends RuntimeException
{
    public function __construct(
        private readonly int $statusCode,
        private readonly string $responseBody,
    ) {
        parent::__construct('UseFlagly error ' . $statusCode . ': ' . $responseBody);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    /** Returns true when the error is a 403 (plan expired / suspended). */
    public function isSubscriptionError(): bool
    {
        return $this->statusCode === 403;
    }

    /** Returns true when the error is a 401. */
    public function isUnauthorized(): bool
    {
        return $this->statusCode === 401;
    }
}
