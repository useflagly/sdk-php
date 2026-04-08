<?php

declare(strict_types=1);

namespace Flagly;

use RuntimeException;

class FlaglyClient
{
    private string $baseUrl;
    private ?string $token;
    private int $timeoutSeconds;

    public function __construct(string $baseUrl, ?string $token = null, int $timeoutSeconds = 10)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->token = $token;
        $this->timeoutSeconds = $timeoutSeconds;
    }

    private function request(string $method, string $path, ?array $body = null, ?string $environment = null): ?array
    {
        $url = $this->baseUrl . $path;

        $headers = ['Content-Type: application/json'];
        if ($this->token !== null) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }
        if ($environment !== null) {
            $headers[] = 'environment: ' . $environment;
        }

        $opts = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->timeoutSeconds,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_CUSTOMREQUEST  => $method,
        ];

        if ($body !== null) {
            $opts[CURLOPT_POSTFIELDS] = json_encode($body);
        }

        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error !== '') {
            throw new RuntimeException('Flagly HTTP error: ' . $error);
        }
        if ($httpCode >= 400) {
            throw new RuntimeException('Flagly server error ' . $httpCode . ': ' . $response);
        }
        if ($httpCode === 204 || $response === '') {
            return null;
        }

        return json_decode($response, true);
    }

    /** GET /validate/health */
    public function healthCheck(): array
    {
        return $this->request('GET', '/validate/health') ?? [];
    }

    /** POST /validate/flag/:slug */
    public function validateFlag(string $slug, ValidateBody $body, ?string $environment = null): array
    {
        return $this->request('POST', '/validate/flag/' . rawurlencode($slug), $body->toArray(), $environment) ?? [];
    }

    /** GET /validate/flag/:slug */
    public function getFlagCache(string $slug, ?string $identifier = null): array
    {
        $path = '/validate/flag/' . rawurlencode($slug);
        if ($identifier !== null) {
            $path .= '?identifier=' . rawurlencode($identifier);
        }
        return $this->request('GET', $path) ?? [];
    }

    /** POST /validate/flow/:slug */
    public function validateFlow(string $slug, ValidateBody $body, ?string $environment = null): array
    {
        return $this->request('POST', '/validate/flow/' . rawurlencode($slug), $body->toArray(), $environment) ?? [];
    }

    /** GET /validate/flow/:slug */
    public function getFlowCache(string $slug, ?string $identifier = null): array
    {
        $path = '/validate/flow/' . rawurlencode($slug);
        if ($identifier !== null) {
            $path .= '?identifier=' . rawurlencode($identifier);
        }
        return $this->request('GET', $path) ?? [];
    }

    /** POST /validate/flow-part/:slug */
    public function validateFlowPart(string $slug, ValidateBody $body, ?string $environment = null): array
    {
        return $this->request('POST', '/validate/flow-part/' . rawurlencode($slug), $body->toArray(), $environment) ?? [];
    }

    /** GET /validate/flow-part/:slug */
    public function getFlowPartCache(string $slug, ?string $identifier = null): array
    {
        $path = '/validate/flow-part/' . rawurlencode($slug);
        if ($identifier !== null) {
            $path .= '?identifier=' . rawurlencode($identifier);
        }
        return $this->request('GET', $path) ?? [];
    }

    /** POST /validate/scenario/:slug */
    public function validateScenario(string $slug, ValidateBody $body, ?string $environment = null): array
    {
        return $this->request('POST', '/validate/scenario/' . rawurlencode($slug), $body->toArray(), $environment) ?? [];
    }

    /** GET /validate/scenario/:slug */
    public function getScenarioCache(string $slug, ?string $identifier = null): array
    {
        $path = '/validate/scenario/' . rawurlencode($slug);
        if ($identifier !== null) {
            $path .= '?identifier=' . rawurlencode($identifier);
        }
        return $this->request('GET', $path) ?? [];
    }

    /** POST /validate/initialize */
    public function initialize(ReceiveMessage $body, ?string $environment = null): ?array
    {
        return $this->request('POST', '/validate/initialize', $body->toArray(), $environment);
    }

    /** GET /validate/result/:identifier */
    public function getResult(string $identifier): array
    {
        return $this->request('GET', '/validate/result/' . rawurlencode($identifier)) ?? [];
    }
}
