<?php

namespace Organiseyou\Client\Types;

class Dashboard
{
    public string $id;
    public string $name;
    public ?string $label;
    /** @var Grid[] */
    public array $grids = [];
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->name = $data['name'] ?? '';
        $instance->label = $data['label'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['grids']) && is_array($data['grids'])) {
            $instance->grids = array_map(fn($g) => Grid::fromArray($g), $data['grids']);
        }

        return $instance;
    }
}
