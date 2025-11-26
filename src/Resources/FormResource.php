<?php

namespace Organiseyou\Client\Resources;

use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Form;

class FormResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $id
     * @return Form[]
     */
    public function list(?string $id = null): array
    {
        $query = <<<'GQL'
query forms($id: String) {
    forms(id: $id) {
        id
        name
        label
        created_at
        updated_at
        fields {
            id
            entity_id
            entity_column_id
            name
            label
            required
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

        return array_map(fn($item) => Form::fromArray($item), $data['forms'] ?? []);
    }
}
