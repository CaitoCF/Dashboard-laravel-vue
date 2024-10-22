<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Sale;
use DB;
use stdClass;
use \YaLinqo\Enumerable as E;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = Carbon::now()->locale('us');
        $months[] = $dt->monthName;
        for ($i = 1; $i < 5; $i++) {
            $month = $dt->month -$i;
            $date = Carbon::createFromDate(Carbon::now()->year, $month, 1);
            $months[] = $date->monthName;
        }

        $months = array_reverse($months);

        foreach ($months as $month) {
            $date = Carbon::parse($month)->format('Y-m-d');
            $sales_month[$month] = count(Sale::where('creation_date', 'regexp', '/^'.$date.'.*/')->get()->toArray());
        }

        $daySales = Sale::where('creation_date', 'regexp', '/^'.Carbon::now()->format('Y-m-d').'.*/')->get()->toArray();
        $day_sales['total_sales'] = count($daySales);
        $day_sales['total_value'] = array_sum(array_column($daySales, 'value'));

        $weekSales = Sale::where('creation_date', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))->orWhere('creation_date', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'))->get()->toArray();
        $week_sales['total_sales'] = count($weekSales);
        $week_sales['total_value'] = array_sum(array_column($weekSales, 'value'));

        $monthSales = Sale::where('creation_date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))->orWhere('creation_date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'))->get()->toArray();
        $month_sales['total_sales'] = count($monthSales);
        $month_sales['total_value'] = array_sum(array_column($monthSales, 'value'));

        $yearSales = Sale::where('creation_date', '>=', Carbon::now()->startOfYear()->format('Y-m-d'))->orWhere('creation_date', '<=', Carbon::now()->endOfYear()->format('Y-m-d'))->get()->toArray();
        $year_sales['total_sales'] = count($yearSales);
        $year_sales['total_value'] = array_sum(array_column($yearSales, 'value'));

        $names = Sale::where('creation_date', '>=', Carbon::now()->startOfYear()->format('Y-m-d'))->orWhere('creation_date', '<=', Carbon::now()->endOfYear()->format('Y-m-d'))->select('name')->distinct()->get()->toArray();
        $array = [];
        foreach ($names as $name) {
            $qttPerName = new stdClass();
            $qtt = Sale::where('creation_date', '>=', Carbon::now()->startOfYear()->format('Y-m-d'))->orWhere('creation_date', '<=', Carbon::now()->endOfYear()->format('Y-m-d'))->where('name', $name[0])->select('_id')->get()->count();
            $qttPerName->name = $name[0];
            $qttPerName->count = $qtt;
            array_push($array, $qttPerName);
        }
        $array = E::from($array)->orderByDescending(function($or) {
            return $or->count;
        })->toList();

        return response()->json([
            'months' => $months,
            'daySales' => $day_sales,
            'weekSales' => $week_sales,
            'monthSales' => $month_sales,
            'yearSales' => $year_sales,
            'salesMonth' => $sales_month,
            'bestSellers' => $array
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
