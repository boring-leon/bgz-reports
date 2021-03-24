<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Transfer;

class ReportsController extends Controller
{

    public function show(Report $report){
        return view('reports.show', compact('report'));
    }

    public function destroy(Report $report){
        $report->delete();
        return redirect()->route('home')->with('success', 'Usunięto report #'. $report->id);
    }

    public function destroyTransfer(Transfer $transfer){
        $transfer->delete();
        return redirect()->route('reports.show', ['report' => $transfer->report_id])->with('success', 'Usunięto transfer #'. $transfer->id);
    }
}
