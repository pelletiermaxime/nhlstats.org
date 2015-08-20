FORMAT: 1A

# Documentation

# AppHttpControllersApiController [/]

## Show all teams [GET /api/teams]
Get a JSON representation of all the teams.

+ Response 200 (application/json)
    + Body

            {
                "teams": [
                    {
                        "id": 31,
                        "short_name": "DET",
                        "city": "Detroit",
                        "name": "Red Wings",
                        "division_id": 5
                    }
                ]
            }

## Show a team [GET /api/team/{id}]
Get a JSON representation of a specific team.

+ Parameters
    + id:31 (integer, required) - ID of the team.

+ Response 200 (application/json)
    + Body

            {
                "team": {
                    "id": 31,
                    "short_name": "DET",
                    "city": "Detroit",
                    "name": "Red Wings",
                    "division_id": 5
                }
            }
