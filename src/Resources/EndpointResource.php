<?php

namespace Organiseyou\Client\Resources;

use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Endpoint;

class EndpointResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $entity_id
     * @return Endpoint[]
     */
    public function list(?string $entity_id = null): array
    {
        $query = <<<'GQL'
query endpoints($entity_id: String) {
    endpoints(entity_id: $entity_id) {
        id
        entity_id
        name
        hasList
        hasGet
        hasPost
        hasPut
        hasDelete
        created_at
        updated_at
        endpointFields {
            id
            endpoint_id
            entity_column_id
            is_required
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, [
            'entity_id' => $entity_id,
        ]);

        return array_map(fn($item) => Endpoint::fromArray($item), $data['endpoints'] ?? []);
    }

    public function get(string $id): ?Endpoint
    {
        $query = <<<'GQL'
query endpoint($id: String!) {
    endpoint(id: $id) {
        id
        entity_id
        name
        hasList
        hasGet
        hasPost
        hasPut
        hasDelete
        created_at
        updated_at
        endpointFields {
            id
            endpoint_id
            entity_column_id
            is_required
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, ['id' => $id]);

        return isset($data['endpoint']) ? Endpoint::fromArray($data['endpoint']) : null;
    }

    public function create(array $input): Endpoint
    {
        $query = <<<'GQL'
mutation createEndpoint($input: EndpointInput) {
    createEndpoint(input: $input) {
        id
        entity_id
        name
        hasList
        hasGet
        hasPost
        hasPut
        hasDelete
        created_at
        updated_at
    }
}
GQL;

        $data = $this->client->query($query, ['input' => $input]);

        return Endpoint::fromArray($data['createEndpoint']);
    }

    public function update(string $id, array $input): Endpoint
    {
        $query = <<<'GQL'
mutation updateEndpoint($id: String!, $input: EndpointInput) {
    updateEndpoint(id: $id, input: $input) {
        id
        entity_id
        name
        hasList
        hasGet
        hasPost
        hasPut
        hasDelete
        created_at
        updated_at
    }
}
GQL;

        $data = $this->client->query($query, ['id' => $id, 'input' => $input]);

        return Endpoint::fromArray($data['updateEndpoint']);
    }

    public function delete(string $id): bool
    {
        $query = <<<'GQL'
mutation deleteEndpoint($id: String!) {
    deleteEndpoint(id: $id)
}
GQL;

        $data = $this->client->query($query, ['id' => $id]);

        return $data['deleteEndpoint'] ?? false;
    }
}
