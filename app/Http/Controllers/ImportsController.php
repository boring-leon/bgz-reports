<?php

namespace App\Http\Controllers;

use App\Rules\ExcelFile;
use Illuminate\Http\Request;
use App\Imports\BankReportImport;
use App\Imports\Support\TransfersFilter;
use Illuminate\Support\Carbon;
use \PhpOffice\PhpSpreadsheet\Shared\Date as OfficeDate;

use App\Models\Transfer;

class ImportsController extends Controller
{
    public function __invoke(Request $request){
        $this->validate($request, [
            'rent' => ['required', 'numeric', 'min:0'],
            'report' => ['required', 'file', new ExcelFile]
        ]);
        
        $data = collect((new BankReportImport)->toArray($request->file('report'))[0])->map(function($row){
            return array_merge($row, [
                'data_zlecenia_operacji' => $this->parseDateOnKey($row, 'data_zlecenia_operacji'),
                'data_realizacji' => $this->parseDateOnKey($row, 'data_realizacji'),
                'data_odrzucenia' => $this->parseDateOnKey($row, 'data_odrzucenia')
            ]);
        });

        $transfers = (new TransfersFilter($data))->withoutInternalTransfers()->withoutRentTransfer($request->rent)->get();
    
        $expenses = $transfers->filter(function($transfer){ 
            return $transfer['kwota_zlecenia'] < 0; 
        })->sum('kwota_zlecenia');

        $salary = $transfers->filter(function($transfer){ 
            return $transfer['kwota_zlecenia'] > 0; 
        })->sum('kwota_zlecenia');
        
        $report = auth()->user()->reports()->create($request->only('rent') + [
            'expenses' => abs($expenses),
            'salary' => $salary,
            'name' => $request->name,
            'start_date' => $transfers->last()['data_zlecenia_operacji'],
            'end_date' =>  $transfers->first()['data_zlecenia_operacji']
        ]);
        
        Transfer::withoutEvents(function() use ($transfers, $report){
            $transfers->each(function($transfer) use($report){
                $report->transfers()->create($transfer);
            });
        });
        
        return redirect()->route('home')->with('success', 'Raport został zapisany');
    }

    private function parseDateOnKey(array $row, $key){
        return is_null($row[$key]) ? null : Carbon::instance(OfficeDate::excelToDateTimeObject($row[$key]))->toDateString();
    }
}
