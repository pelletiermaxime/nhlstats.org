# How to update for new season

* Update values in config/nhlstats.php
* Create teams for new year:

```mysql
INSERT INTO teams (short_name, city, name, year, division_id)
(SELECT short_name, city, name, 2019, division_id FROM teams WHERE year = 2018);
```
