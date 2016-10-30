<?php

namespace Nhlstats\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class DivisionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Division',
        'description' => 'Divisions'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the division'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the division'
            ],
            'year' => [
                'type' => Type::int(),
                'description' => 'The current year of the division'
            ],
            'conference' => [
                'type' => Type::string(),
                'description' => 'The conference of the division'
            ],
        ];
    }

    protected function resolveNameField($root)
    {
        return ucwords(strtolower($root->division));
    }

    protected function resolveConferenceField($root)
    {
        return ucwords(strtolower($root->conference));
    }
}
