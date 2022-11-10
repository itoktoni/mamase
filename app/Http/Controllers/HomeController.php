<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Plugins\Query;
use Plugins\Template;
use App\Charts\dashboard;
use App\Dao\Enums\TicketStatus;
use App\Dao\Models\TicketSystem;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->check() && auth()->user()->active == false){
            return redirect()->to('/');
        }

        $chart = new dashboard();
        for ($m=1; $m<=12; $m++) {
            $month[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
            $booking = TicketSystem::whereMonth(TicketSystem::field_reported_at(), $m)
            ->whereYear(TicketSystem::field_reported_at(), date('Y'));

            $target[] = $booking->count();
            $pencapaian[] = $booking->where(TicketSystem::field_status(), TicketStatus::Finish)->count();
        }

        $chart->labels($month);
        $chart->dataset('Total Tiket', 'bar', $target)->backgroundColor('#ddf1fa')->fill(true);
        $chart->dataset('Total Pekerjaan Selesai', 'bar', $pencapaian)->backgroundColor('#0088cc')->fill(true);

        $chart->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);

        return view('home')->with(['chart' => $chart]);
    }
}
