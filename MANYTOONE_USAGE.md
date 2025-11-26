# OrganiseYou PHP Client - ManyToOne Relationships

This document demonstrates how to use the updated PHP client library with the new manyToOne relationship support.

## Overview

The `EntityColumn` type now supports manyToOne relationships with two new fields:
- `related_entity_id`: The **name** of the related entity (e.g., "customers", "products")
- `related_entity_display_field`: The field name to display from the related entity

> **Note**: Despite its name, `related_entity_id` actually stores the entity **name**, not the UUID.

## Example: Creating an Entity with ManyToOne Relationship

```php
use Organiseyou\Client\Client;

$client = new Client('https://your-api-url.com', 'your-bearer-token');

// First, create a "Customer" entity
$customerEntity = $client->entities()->create([
    'name' => 'customer',
    'label' => 'Customer',
    'columns' => [
        [
            'name' => 'name',
            'label' => 'Customer Name',
            'type' => 'string'
        ],
        [
            'name' => 'email',
            'label' => 'Email',
            'type' => 'string'
        ]
    ]
]);

// Then, create an "Order" entity with a manyToOne relationship to Customer
$orderEntity = $client->entities()->create([
    'name' => 'order',
    'label' => 'Order',
    'columns' => [
        [
            'name' => 'order_number',
            'label' => 'Order Number',
            'type' => 'string'
        ],
        [
            'name' => 'customer',
            'label' => 'Customer',
            'type' => 'manyToOne',
            'related_entity_id' => 'customer',  // Entity name, not ID!
            'related_entity_display_field' => 'name'  // Display customer name
        ],
        [
            'name' => 'total',
            'label' => 'Total Amount',
            'type' => 'integer'
        ]
    ]
]);
```

## Example: Reading Entity Columns with Relationships

```php
// Fetch an entity and inspect its columns
$entity = $client->entities()->get($orderEntity->id);

foreach ($entity->columns as $column) {
    echo "Column: {$column->label} ({$column->type})\n";
    
    if ($column->type === 'manyToOne') {
        echo "  → Related Entity Name: {$column->related_entity_id}\n";
        echo "  → Display Field: {$column->related_entity_display_field}\n";
    }
}
```

## Example: Updating a Column to Add a Relationship

```php
// Update an existing column to become a manyToOne relationship
$client->entities()->update($orderEntity->id, [
    'name' => 'order',
    'label' => 'Order',
    'columns' => [
        [
            'id' => $existingColumnId,
            'name' => 'customer',
            'label' => 'Customer',
            'type' => 'manyToOne',
            'related_entity_id' => 'customer',  // Entity name
            'related_entity_display_field' => 'email'  // Changed to display email
        ]
    ]
]);
```

## Field Reference

### EntityColumn Properties

| Property | Type | Description |
|----------|------|-------------|
| `id` | `string` | Column ID (UUID) |
| `entity_id` | `string` | Parent entity ID |
| `name` | `string` | Column name |
| `label` | `string` | Column label |
| `description` | `?string` | Column description |
| `type` | `string` | Column type (string, integer, boolean, datetime, oneToMany, **manyToOne**) |
| `related_entity_id` | `?string` | **NEW**: Related entity **name** (for manyToOne relationships, e.g., "customer") |
| `related_entity_display_field` | `?string` | **NEW**: Field to display from related entity |
| `settings` | `?string` | Column settings (JSON) |
| `sort` | `?int` | Sort order |
| `created_at` | `?string` | Creation timestamp |
| `updated_at` | `?string` | Last update timestamp |

## Notes

- The `related_entity_id` field stores the **entity name** (not the UUID), despite its misleading name
- The `related_entity_id` and `related_entity_display_field` are only relevant when `type` is set to `manyToOne`
- These fields are nullable and will be `null` for non-relationship column types
- The `related_entity_display_field` should reference a valid column name in the related entity
