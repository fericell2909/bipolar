<?php

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class ProductFilters extends InputType
{
    protected $attributes = [
        'name'        => 'ProductFilters',
        'description' => 'Filter fields for products',
    ];

    public function fields(): array
    {
        return [
            'search'       => [
                'type'        => Type::string(),
                'description' => 'Search by name',
            ],
            'state'        => [
                'type'        => Type::string(),
                'description' => 'Search by state id',
            ],
            'subtype'      => [
                'type'        => Type::string(),
                'description' => 'Search by subtype id',
            ],
            'creation_date' => [
                'type'        => Type::string(),
                'description' => 'Search by creation date',
            ],
        ];
    }
}
