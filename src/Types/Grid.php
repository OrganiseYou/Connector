<?php

namespace Organiseyou\Client\Types;

class Grid
{
    public string $id;
    public ?string $name;
    public ?string $label;
    /** @var GridColumn[] */
    public array $columns = [];
    public ?Form $new_form;
    public ?Form $edit_form;
    /** @var Dashboard[] */
    public array $dashboards = [];
    public ?string $created_at;
    public ?string $updated_at;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'] ?? '';
        $instance->name = $data['name'] ?? null;
        $instance->label = $data['label'] ?? null;
        $instance->created_at = $data['created_at'] ?? null;
        $instance->updated_at = $data['updated_at'] ?? null;

        if (isset($data['columns']) && is_array($data['columns'])) {
            $instance->columns = array_map(fn($c) => GridColumn::fromArray($c), $data['columns']);
        }

        if (isset($data['new_form']) && is_array($data['new_form'])) {
            $instance->new_form = Form::fromArray($data['new_form']);
        } else {
            $instance->new_form = null;
        }

        if (isset($data['edit_form']) && is_array($data['edit_form'])) {
            $instance->edit_form = Form::fromArray($data['edit_form']);
        } else {
            $instance->edit_form = null;
        }

        if (isset($data['dashboards']) && is_array($data['dashboards'])) {
            $instance->dashboards = array_map(fn($d) => Dashboard::fromArray($d), $data['dashboards']);
        }

        return $instance;
    }
}
