<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExcelFile implements Rule
{
    public function passes($attribute, $value){
        return in_array(request()->file($attribute)->extension(), ['xlsx', 'xls']);
    }

    public function message(){
        return 'Przesłany raport musi być arkuszem programu Excel, z włączonym trybem edycji!';
    }
}
