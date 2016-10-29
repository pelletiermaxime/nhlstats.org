<?php

namespace Nhlstats\GraphQL\Query;

use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Nhlstats\Http\Models\Team;

class TeamQuery extends Query
{
    protected $attributes = [
        'name'        => 'team',
        'description' => 'A query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Team'));
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

        $teams = Team::query();

        foreach (array_keys($fields) as $field) {
            if ($field === 'division') {
                $teams->with('division');
            }
        }

        if (isset($args['id'])) {
            $teams->whereId($args['id'])->where('year', config('nhlstats.currentYear'));
        } else {
            $teams->where('year', config('nhlstats.currentYear'));
        }
        return $teams->get();
    }
}
