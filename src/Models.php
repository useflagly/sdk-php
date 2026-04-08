<?php
// Code generated from JSON Schema. DO NOT EDIT.

declare(strict_types=1);

namespace Flagly;

class ValidateBody
{
    public function __construct(
        public readonly ?string $identifier = null,
        public readonly ?array $context = null,
    ) {}

    public function toArray(): array
    {
        $result = [];
        if ($this->identifier !== null) {
            $result['identifier'] = $this->identifier;
        }
        if ($this->context !== null) {
            $result['context'] = $this->context;
        }
        return $result;
    }

    public static function fromArray(array $d): self
    {
        return new self(identifier: $d['identifier'] ?? null, context: $d['context'] ?? null);
    }
}

class ReceiveMessage
{
    public function __construct(
        public readonly string $identifier,
        public readonly string $slug,
        public readonly ?float $companyId = null,
        public readonly ?array $context = null,
    ) {}

    public function toArray(): array
    {
        $result = ['identifier' => $this->identifier, 'slug' => $this->slug];
        if ($this->companyId !== null) {
            $result['companyId'] = $this->companyId;
        }
        if ($this->context !== null) {
            $result['context'] = $this->context;
        }
        return $result;
    }

    public static function fromArray(array $d): self
    {
        return new self(
            identifier: $d['identifier'],
            slug: $d['slug'],
            companyId: isset($d['companyId']) ? (float) $d['companyId'] : null,
            context: $d['context'] ?? null,
        );
    }
}
