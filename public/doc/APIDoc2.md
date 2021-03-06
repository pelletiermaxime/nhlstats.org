FORMAT: 1A

# Documentation

## Teams [/api/teams]

### Show all teams [GET]
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

## Team [/api/team/{id}]

### Show a team [GET]
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
