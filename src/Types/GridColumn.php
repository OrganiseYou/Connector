<?php

namespace Organiseyou\Client\Types;

class GridColumn
{
    public string $id;
    public ?string $label;
    public ?string $name;
    public ?string $entity_id;
    public ?string $entity_column_id;
    public ?int $sort;
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->label = $data['label'] ?? null;
        $instance->name = $data['name'] ?? null;
        $instance->entity_id = $data['entity_id'] ?? null;
        $instance->entity_column_id = $data['entity_column_id'] ?? null;
        $instance->sort = $data['sort'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        return $instance;
    }
}
