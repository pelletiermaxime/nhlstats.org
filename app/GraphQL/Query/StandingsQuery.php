<?php

namespace Nhlstats\GraphQL\Query;

use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Nhlstats\Http\Models\Standings;

class StandingsQuery extends Query
{
    protected $attributes = [
        'name'        => 'standings',
        'description' => 'Team standings query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Standing'));
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(3);

        $standings = Standings::query();

        foreach (array_keys($fields) as $field) {
            if ($field === 'team') {
                $standings->with('team.division');
            }
        }

        if (isset($args['id'])) {
            $standings->whereId($args['id']);
        }
        $standings->where('year', config('nhlstats.currentYear'));

        return $standings->get();
    }
}
