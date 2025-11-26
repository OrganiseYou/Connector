<?php

namespace Organiseyou\Client\Resources;

use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Entity;

class EntityResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $id
     * @param string|null $name
     * @return Entity[]
     */
    public function list(?string $id = null, ?string $name = null): array
    {
        $query = <<<'GQL'
query entitiesList($id: String, $name: String) {
    entitiesList(id: $id, name: $name) {
        id
        name
        label
        created_at
        updated_at
        columns {
            id
            entity_id
            name
            label
            description
            type
            settings
            sort
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, [
            'id' => $id,
            'name' => $name,
        ]);

        return array_map(fn($item) => Entity::fromArray($item), $data['entitiesList'] ?? []);
    }

    public function get(string $id): ?Entity
    {
        $entities = $this->list(id: $id);
        return $entities[0] ?? null;
    }

    public function create(array $input): Entity
    {
        $query = <<<'GQL'
mutation createEntity($input: EntityInput) {
    createEntity(input: $input) {
        id
        name
        label
        created_at
        updated_at
        columns {
            id
            entity_id
            name
            label
            description
            type
            settings
            sort
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, ['input' => $input]);

        return Entity::fromArray($data['createEntity']);
    }

    public function update(string $id, array $input): Entity
    {
        $query = <<<'GQL'
mutation updateEntity($id: String!, $input: EntityInput) {
    updateEntity(id: $id, input: $input) {
        id
        name
        label
        created_at
        updated_at
        columns {
            id
            entity_id
            name
            label
            description
            type
            settings
            sort
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, ['id' => $id, 'input' => $input]);

        return Entity::fromArray($data['updateEntity']);
    }

    public function delete(string $id): bool
    {
        $query = <<<'GQL'
mutation deleteEntity($id: String!) {
    deleteEntity(id: $id)
}
GQL;

        $data = $this->client->query($query, ['id' => $id]);

        return $data['deleteEntity'] ?? false;
    }
}
