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

class TextConditionStatusUpdation extends Mutation
{
    protected $attributes = [
        'name'        => 'products_conditions_text',
        'description' => 'Update the state of text condition',
    ];

    public function type(): Type
    {
        return \GraphQL::type('text_condition');
    }

    public function args(): array
    {
        return [
            'uuid'  => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

    
        $textCondition = TextCondition::where('uuid',$args['uuid'])->first();

        if($textCondition->available == 1){
            $textCondition->available = false;
        } else {

            TextCondition::where('id','>',0)->update(['available' => 0]);
            $textCondition->available = true;
        }
                      
        $textCondition->save();
        
        return $textCondition;

    }
}
