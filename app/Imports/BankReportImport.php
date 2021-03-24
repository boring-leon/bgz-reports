<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankReportImport implements WithHeadingRow, ToCollection
{
    use Importable;

    public function collection(Collection $collection){
        //
    }
}
