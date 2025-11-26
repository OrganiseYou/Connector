<?php

namespace Organiseyou\Client\Types;

class ImporterResource
{
    public string $id;
    public string $importer_id;
    public ?bool $is_test;
    public string $name;
    public string $endpoint;
    public ?string $date_field;
    public ?string $field_map;
    public ?string $created_at;
    public ?string $updated_at;
    public ?Importer $importer;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->importer_id = $data['importer_id'] ?? '';
        $instance->is_test = $data['is_test'] ?? null;
        $instance->name = $data['name'] ?? '';
        $instance->endpoint = $data['endpoint'] ?? '';
        $instance->date_field = $data['date_field'] ?? null;
        $instance->field_map = $data['field_map'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['importer']) && is_array($data['importer'])) {
            $instance->importer = Importer::fromArray($data['importer']);
        } else {
            $instance->importer = null;
        }

        return $instance;
    }
}
