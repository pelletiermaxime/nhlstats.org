<?php

namespace Nhlstats\GraphQL\Type;

use Folklore\GraphQL\Support\Facades\GraphQL;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class StandingType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Standing',
        'description' => 'Team standings'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the standing'
            ],
            'year' => [
                'type' => Type::int(),
                'description' => 'The year of the standing'
            ],
            'gp' => [
                'type' => Type::int(),
                'description' => 'Game played'
            ],
            'w' => [
                'type' => Type::int(),
                'description' => 'Wins'
            ],
            'l' => [
                'type' => Type::int(),
                'description' => 'Losses'
            ],
            'otl' => [
                'type' => Type::int(),
                'description' => 'Overtime losses'
            ],
            'pts' => [
                'type' => Type::int(),
                'description' => 'Points'
            ],
            'row' => [
                'type' => Type::int(),
                'description' => 'row'
            ],
            'gf' => [
                'type' => Type::int(),
                'description' => 'Goals for'
            ],
            'ga' => [
                'type' => Type::int(),
                'description' => 'Goals against'
            ],
            'ppp' => [
                'type' => Type::int(),
                'description' => 'ppp'
            ],
            'pkp' => [
                'type' => Type::int(),
                'description' => 'pkp'
            ],
            'home' => [
                'type' => Type::string(),
                'description' => 'Home wins-losses-otl'
            ],
            'away' => [
                'type' => Type::string(),
                'description' => 'Away wins-losses-otl'
            ],
            'l10' => [
                'type' => Type::string(),
                'description' => 'Last 10 games wins-losses-otl'
            ],
            'diff' => [
                'type' => Type::string(),
                'description' => 'Goals differential'
            ],
            'streak' => [
                'type' => Type::string(),
                'description' => 'Wins or losses streak'
            ],
            'ppg' => [
                'type' => Type::int(),
                'description' => 'ppg'
            ],
            'ppo' => [
                'type' => Type::int(),
                'description' => 'ppo'
            ],
            'ppga' => [
                'type' => Type::int(),
                'description' => 'ppga'
            ],
            'ppoa' => [
                'type' => Type::int(),
                'description' => 'ppoa'
            ],
            'positionOverall' => [
                'type' => Type::int(),
                'description' => 'Overall position in the league'
            ],
            'positionConference' => [
                'type' => Type::int(),
                'description' => 'Conference position'
            ],
            'team' => [
                'type' => GraphQL::type('Team'),
                'description' => 'The team',
            ],
        ];
    }
}
