<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\TextCondition;

use Illuminate\Support\Str;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class TextConditionUpdation extends Mutation
{
    protected $attributes = [
        'name'        => 'products_conditions_text',
        'description' => 'Update a text condition',
    ];

    public function type(): Type
    {
        return \GraphQL::type('text_condition');
    }

    public function args(): array
    {
        return [
            'uuid'         => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
            'name'         => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'name_english' => ['name' => 'name_english', 'type' => Type::nonNull(Type::string())],
            'description'  => ['name' => 'description', 'type' => Type::nonNull(Type::string())],
            'description_english' => ['name' => 'description_english', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        // only one text condition available

        $textCondition = TextCondition::where('uuid', $args['uuid'])->first();

        $textCondition->name = $args['name'];

        $textCondition->setTranslations('name', [
            'es' => $args['name'],
            'en' => $args['name_english'],
        ]);

        $textCondition->setTranslations('description', [
            'es' => $args['description'],
            'en' => $args['description_english'],
        ]);

        $textCondition->save();
        
        return $textCondition;

    }
}
