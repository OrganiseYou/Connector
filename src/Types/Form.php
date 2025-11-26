<?php

namespace Organiseyou\Client\Types;

class Form
{
    public string $id;
    public ?string $name;
    public string $label;
    /** @var FormField[] */
    public array $fields = [];
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->name = $data['name'] ?? null;
        $instance->label = $data['label'] ?? '';
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['fields']) && is_array($data['fields'])) {
            $instance->fields = array_map(fn($f) => FormField::fromArray($f), $data['fields']);
        }

        return $instance;
    }
}
