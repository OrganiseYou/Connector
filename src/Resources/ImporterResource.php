<?php

namespace Organiseyou\Client\Resources;

use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Importer;

class ImporterResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Importer[]
     */
    public function list(): array
    {
        $query = <<<'GQL'
query importers {
    importers {
        id
        enabled
        base_url
        auth
        headers
        entity_id
        rate_limit
        rate_limit_interval
        pagination_type
        pagination_page_param
        pagination_per_page_param
        pagination_per_page_value
        verify_ssl
        created_at
        updated_at
        importer_resources {
            id
            importer_id
            is_test
            name
            endpoint
            date_field
            field_map
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query);

        return array_map(fn($item) => Importer::fromArray($item), $data['importers'] ?? []);
    }

    public function get(string $id): ?Importer
    {
        $query = <<<'GQL'
query importer($id: String!) {
    importer(id: $id) {
        id
        enabled
        base_url
        auth
        headers
        entity_id
        rate_limit
        rate_limit_interval
        pagination_type
        pagination_page_param
        pagination_per_page_param
        pagination_per_page_value
        verify_ssl
        created_at
        updated_at
        importer_resources {
            id
            importer_id
            is_test
            name
            endpoint
            date_field
            field_map
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, ['id' => $id]);

        return isset($data['importer']) ? Importer::fromArray($data['importer']) : null;
    }

    public function create(array $input): Importer
    {
        $query = <<<'GQL'
mutation createImporter($input: ImporterInput) {
    createImporter(input: $input) {
        id
        enabled
        base_url
        auth
        headers
        entity_id
        rate_limit
        rate_limit_interval
        pagination_type
        pagination_page_param
        pagination_per_page_param
        pagination_per_page_value
        verify_ssl
        created_at
        updated_at
    }
}
GQL;

        $data = $this->client->query($query, ['input' => $input]);

        return Importer::fromArray($data['createImporter']);
    }

    public function update(string $id, array $input): Importer
    {
        $query = <<<'GQL'
mutation updateImporter($id: String!, $input: ImporterInput) {
    updateImporter(id: $id, input: $input) {
        id
        enabled
        base_url
        auth
        headers
        entity_id
        rate_limit
        rate_limit_interval
        pagination_type
        pagination_page_param
        pagination_per_page_param
        pagination_per_page_value
        verify_ssl
        created_at
        updated_at
    }
}
GQL;

        $data = $this->client->query($query, ['id' => $id, 'input' => $input]);

        return Importer::fromArray($data['updateImporter']);
    }

    public function delete(string $id): bool
    {
        $query = <<<'GQL'
mutation deleteImporter($id: String!) {
    deleteImporter(id: $id)
}
GQL;

        $data = $this->client->query($query, ['id' => $id]);

        return $data['deleteImporter'] ?? false;
    }
}
