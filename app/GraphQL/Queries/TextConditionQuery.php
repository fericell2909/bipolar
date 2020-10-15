<?php

namespace App\GraphQL\Queries;

use App\Models\TextCondition;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;

class TextConditionQuery extends Query
{
    protected $attributes = [
        'name'        => 'text_conditions',
        'description' => 'Get by uuid or list of text conditions',
    ];

    public function type(): Type
    {
        return Type::listOf(\GraphQL::type('text_condition'));
    }

    public function args(): array
    {
        return [
            'uuid'    => ['name' => 'uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();

        if(@$args['uuid'] == ''){
        //if(@$args['uuid']){
            $textConditions = TextCondition::where('id','>',0)->get();
        } else {
            
            $textConditions = TextCondition::where('uuid',$args['uuid'])->get();

        }
       
        return $textConditions;
    }

}
