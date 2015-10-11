<?hh

namespace app\Http\Controllers;

use App\Http\Models\DateHelper;
use App\Http\Models\GameScores;
use App\Http\Controllers\Controller;

class ScoresController extends Controller
{
    public function index($date = null)
    {
        $dates = DateHelper::getDates($date);

        $scores = GameScores::whereDateGame($dates['today'])
            ->with(['team1', 'team2'])
            ->get()
        ;

        return view('scores')
            ->withScores($scores)
            ->withDates($dates)
        ;
    }
}
