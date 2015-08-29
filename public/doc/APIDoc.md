FORMAT: 1A

# Documentation

# Teams [/api/teams]

## Show all teams [GET]
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

# Team [/api/team/{id}]

## Show a team [GET]
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

# Scores [/api/scores]

## Show all scores [GET /api/scores/{date}]
Get a JSON representation of the scores of a day. Defaults to today.

+ Parameters
    + date:`2015-05-12` (string, optional) - Date of the scores. Defaults to today.

+ Response 200 (application/json)
    + Body

            {
                "game_scores": [
                    {
                        "team1_id": "56",
                        "score1_1": "0",
                        "score1_2": "0",
                        "score1_3": "1",
                        "score1_OT": "0",
                        "score1_SO": null,
                        "score1_T": "1",
                        "team2_id": "42",
                        "score2_1": "1",
                        "score2_2": "2",
                        "score2_3": "1",
                        "score2_OT": "0",
                        "score2_SO": null,
                        "score2_T": "4",
                        "date_game": "2015-05-12",
                        "year": "1415",
                        "team1": {
                            "id": "56",
                            "short_name": "MTL",
                            "city": "Montreal",
                            "name": "Canadiens",
                            "year": "1415",
                            "division_id": "5"
                        },
                        "team2": {
                            "id": "42",
                            "short_name": "TBL",
                            "city": "Tampa Bay",
                            "name": "Lightning",
                            "year": "1415",
                            "division_id": "5"
                        }
                    }
                ]
            }