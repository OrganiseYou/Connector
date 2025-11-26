<?php

namespace Organiseyou\Client\Types;

class Importer
{
    public string $id;
    public bool $enabled;
    public string $base_url;
    public ?string $auth;
    public ?string $headers;
    public string $entity_id;
    public ?int $rate_limit;
    public ?int $rate_limit_interval;
    public ?string $pagination_type;
    public ?string $pagination_page_param;
    public ?string $pagination_per_page_param;
    public ?int $pagination_per_page_value;
    public ?bool $verify_ssl;
    public ?string $created_at;
    public ?string $updated_at;
    /** @var ImporterResource[] */
    public array $importer_resources = [];

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->enabled = $data['enabled'] ?? false;
        $instance->base_url = $data['base_url'] ?? '';
        $instance->auth = $data['auth'] ?? null;
        $instance->headers = $data['headers'] ?? null;
        $instance->entity_id = $data['entity_id'] ?? '';
        $instance->rate_limit = $data['rate_limit'] ?? null;
        $instance->rate_limit_interval = $data['rate_limit_interval'] ?? null;
        $instance->pagination_type = $data['pagination_type'] ?? null;
        $instance->pagination_page_param = $data['pagination_page_param'] ?? null;
        $instance->pagination_per_page_param = $data['pagination_per_page_param'] ?? null;
        $instance->pagination_per_page_value = $data['pagination_per_page_value'] ?? null;
        $instance->verify_ssl = $data['verify_ssl'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['importer_resources']) && is_array($data['importer_resources'])) {
            $instance->importer_resources = array_map(fn($r) => ImporterResource::fromArray($r), $data['importer_resources']);
        }

        return $instance;
    }
}
