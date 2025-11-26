<?php

namespace Organiseyou\Client\Resources;

use Organiseyou\Client\Client;
use Organiseyou\Client\Types\Dashboard;

class DashboardResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $id
     * @return Dashboard[]
     */
    public function list(?string $id = null): array
    {
        $query = <<<'GQL'
query dashboards($id: String) {
    dashboards(id: $id) {
        id
        name
        label
        created_at
        updated_at
        grids {
            id
            name
            label
            created_at
            updated_at
        }
    }
}
GQL;

        $data = $this->client->query($query, [
            'id' => $id,
        ]);

        return array_map(fn($item) => Dashboard::fromArray($item), $data['dashboards'] ?? []);
    }
}
