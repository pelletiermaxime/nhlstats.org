<?php

if (! function_exists('current_year')) {
    function current_year()
    {
        return app('config')->get('nhlstats.currentYear');
    }
}
