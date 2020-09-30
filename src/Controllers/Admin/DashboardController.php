<?php

namespace Xmen\StarterKit\Controllers\Admin;

use Xmen\StarterKit\Helpers\TDate;
use Xmen\StarterKit\Models\Post;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($y = null, $m = null) {
        $dt = TDate::GetInstance();
        if ($y == null) {
            $time = time();
            $y = $dt->PDate('Y');
            $m = $dt->PDate('m');
        } else {
            $time = $dt->Parsi2Timestamp("$y/$m/01");
        }
        $nm = ($m + 1) % 12;
        $ny = ($m + 1 == 13 ? $y + 1 : $y);
        $pm = $m - 1;
        if ($pm == 0) {
            $pm = 12;
            $py = $y - 1;
        } else {
            $py = $y;
        }
        $start = $dt->PThisMonthStartEx($time);
        $end = $dt->PThisMonthEndEx($time);
        $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                ],
                [
                    "label" => "My Second dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [12, 33, 44, 44, 55, 23, 40],
                ]
            ])
            ->options([]);

        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Label x', 'Label y'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [69, 59]
                ]
            ])
            ->options([]);

        return view('starter-kit::admin.dashboard', compact('dt', 'time', 'start', 'end', 'nm', 'ny', 'pm', 'py','chartjs','chartjs2'));
    }
}
