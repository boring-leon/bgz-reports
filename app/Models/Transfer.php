<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public $fillable = ['data_zlecenia_operacji', 'data_realizacji', 'data_odrzucenia', 'kwota', 'waluta'];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
