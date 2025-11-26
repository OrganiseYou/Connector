<?php

namespace Organiseyou\Client\Types;

class Endpoint
{
    public string $id;
    public string $entity_id;
    public string $name;
    public ?bool $hasList;
    public ?bool $hasGet;
    public ?bool $hasPost;
    public ?bool $hasPut;
    public ?bool $hasDelete;
    /** @var EndpointField[] */
    public array $endpointFields = [];
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->entity_id = $data['entity_id'] ?? '';
        $instance->name = $data['name'] ?? '';
        $instance->hasList = $data['hasList'] ?? null;
        $instance->hasGet = $data['hasGet'] ?? null;
        $instance->hasPost = $data['hasPost'] ?? null;
        $instance->hasPut = $data['hasPut'] ?? null;
        $instance->hasDelete = $data['hasDelete'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['endpointFields']) && is_array($data['endpointFields'])) {
            $instance->endpointFields = array_map(fn($f) => EndpointField::fromArray($f), $data['endpointFields']);
        }

        return $instance;
    }
}
