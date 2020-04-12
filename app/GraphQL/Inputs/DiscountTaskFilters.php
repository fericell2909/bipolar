<?php

declare(strict_types=1);

namespace App\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class DiscountTaskFilters extends InputType
{
    protected $attributes = [
        'name'        => 'DiscountTaskFilters',
        'description' => 'Filter discount tasks by selected values',
    ];

    public function fields(): array
    {
        return [
            'is_2x1' => [
                'type'        => Type::boolean(),
                'description' => 'Filter if discount is 2x1',
            ],
        ];
    }
}
