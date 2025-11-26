<?php

namespace Organiseyou\Client\Types;

class FormField
{
    public string $id;
    public ?string $entity_id;
    public ?string $entity_column_id;
    public ?string $name;
    public ?string $label;
    public ?bool $required;
    public ?int $sort;
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->entity_id = $data['entity_id'] ?? null;
        $instance->entity_column_id = $data['entity_column_id'] ?? null;
        $instance->name = $data['name'] ?? null;
        $instance->label = $data['label'] ?? null;
        $instance->required = $data['required'] ?? null;
        $instance->sort = $data['sort'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        return $instance;
    }
}
