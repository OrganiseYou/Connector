<?php

namespace Organiseyou\Client\Resources;

use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Grid;

class GridResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $id
     * @return Grid[]
     */
    public function list(?string $id = null): array
    {
        $query = <<<'GQL'
query grids($id: String) {
    grids(id: $id) {
        id
        name
        label
        created_at
        updated_at
        columns {
            id
            label
            name
            entity_id
            entity_column_id
            sort
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, [
            'id' => $id,
        ]);

        return array_map(fn($item) => Grid::fromArray($item), $data['grids'] ?? []);
    }
}
