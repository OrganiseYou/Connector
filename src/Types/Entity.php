<?php

namespace Organiseyou\Client\Types;

class Entity
{
    public string $id;
    public string $name;
    public string $label;
    /** @var EntityColumn[] */
    public array $columns = [];
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->name = $data['name'] ?? '';
        $instance->label = $data['label'] ?? '';
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['columns']) && is_array($data['columns'])) {
            $instance->columns = array_map(fn($col) => EntityColumn::fromArray($col), $data['columns']);
        }

        return $instance;
    }
}
