# useflagly/sdk-php — Flagly SDK para PHP

SDK PHP para a API de feature flags da Flagly.

## Instalação

```bash
composer require useflagly/sdk-php
```

## Uso

```php
use Flagly\FlaglyClient;
use Flagly\Models;

$client = new FlaglyClient(token: 'seu-api-token');
// A URL padrão é https://api.useflagly.com.br — pode ser sobrescrita no primeiro parâmetro

// Validar flag
$result = $client->validateFlag('minha-flag', new Models\ValidateBody(identifier: '00000000000'), 'PRD');

// Ler cache de flag
$cache = $client->getFlagCache('minha-flag', '00000000000');

// Validar flow
$result = $client->validateFlow('meu-flow', new Models\ValidateBody(identifier: '00000000000'), 'PRD');

// Validar flow-part
$result = $client->validateFlowPart('meu-flow-part', new Models\ValidateBody(identifier: '00000000000'), 'PRD');

// Validar scenario
$result = $client->validateScenario('meu-scenario', new Models\ValidateBody(identifier: '00000000000'), 'PRD');

// Inicializar (producer)
$client->initialize(new Models\ReceiveMessage(identifier: '...', slug: '...', companyId: 1), 'PRD');

// Buscar resultado
$result = $client->getResult('00000000000');
```

## Métodos

| Método | Descrição |
|---|---|
| `healthCheck()` | Verifica saúde da API |
| `validateFlag(slug, body, environment?)` | Valida uma feature flag |
| `getFlagCache(slug, identifier?)` | Lê o cache de uma flag |
| `validateFlow(slug, body, environment?)` | Valida um flow |
| `getFlowCache(slug, identifier?)` | Lê o cache de um flow |
| `validateFlowPart(slug, body, environment?)` | Valida um flow-part |
| `getFlowPartCache(slug, identifier?)` | Lê o cache de um flow-part |
| `validateScenario(slug, body, environment?)` | Valida um scenario |
| `getScenarioCache(slug, identifier?)` | Lê o cache de um scenario |
| `initialize(payload, environment?)` | Inicializa flags (producer) |
| `getResult(identifier)` | Busca resultado por identifier |





