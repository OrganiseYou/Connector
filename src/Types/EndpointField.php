<?php

namespace Organiseyou\Client\Types;

class EndpointField
{
    public string $id;
    public string $endpoint_id;
    public string $entity_column_id;
    public ?bool $is_required;
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->endpoint_id = $data['endpoint_id'] ?? '';
        $instance->entity_column_id = $data['entity_column_id'] ?? '';
        $instance->is_required = $data['is_required'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        return $instance;
    }
}
