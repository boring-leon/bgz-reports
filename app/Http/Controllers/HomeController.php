<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function show(){
        $avg_report_period_days = auth()->user()->reports->map(function($report){
            return Carbon::createFromDate($report->start_date)->diffInDays(Carbon::createFromDate($report->end_date));
        })->avg();

        return view('home', compact('avg_report_period_days'));
    }
}
