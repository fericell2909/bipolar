<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\PremiumLink;

use Illuminate\Support\Str;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class PremiumLinkDeletion extends Mutation
{
    protected $attributes = [
        'name'        => 'products_premium_link',
        'description' => 'Elminate records by uuid',
    ];

    public function type(): Type
    {
        return \GraphQL::type('premium_link');
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

    
        $premiumLink = PremiumLink::where('uuid',$args['uuid'])->first();

        $premiumLink->delete();
        
        return $premiumLink;

    }
}
