<?php

namespace Organiseyou\Client\Types;

class EntityColumn
{
    public string $id;
    public string $entity_id;
    public string $name;
    public string $label;
    public ?string $description;
    public string $type;
    public ?string $settings;
    public ?int $sort;
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->entity_id = $data['entity_id'] ?? '';
        $instance->name = $data['name'] ?? '';
        $instance->label = $data['label'] ?? '';
        $instance->description = $data['description'] ?? null;
        $instance->type = $data['type'] ?? '';
        $instance->settings = $data['settings'] ?? null;
        $instance->sort = $data['sort'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        return $instance;
    }
}
