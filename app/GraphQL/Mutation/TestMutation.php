<?php

namespace Nhlstats\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class TestMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'test',
        'description' => 'A mutation',
    ];

    public function type()
    {
        return Type::listOf(Type::string());
    }

    public function args()
    {
        return [

        ];
    }

    public function resolve($root, $args)
    {
        return [];
    }
}
