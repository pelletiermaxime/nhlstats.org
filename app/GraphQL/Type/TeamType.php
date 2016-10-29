<?php

namespace Nhlstats\GraphQL\Type;

use Folklore\GraphQL\Support\Facades\GraphQL;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class TeamType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Team',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the team'
            ],
            'short_name' => [
                'type' => Type::string(),
                'description' => 'The short name of the team'
            ],
            'city' => [
                'type' => Type::string(),
                'description' => 'The city of the team'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The city of the team'
            ],
            'year' => [
                'type' => Type::int(),
                'description' => 'The current year of the team'
            ],
            'division' => [
                'type' => GraphQL::type('Division'),
                'description' => 'The team division',
            ],
        ];
    }
}
