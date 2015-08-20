FORMAT: 1A

# Documentation

# AppHttpControllersApiController [/api]

## Teams Collection [/teams]
### List all teams [GET]
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

## Group Team

Resources related to teams in the API.

## Team [/team/{id}]

## View a team [GET]
Get a JSON representation of a specific team.

+ Parameters
    + id: 31 (integer, required) - ID of the team.

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
