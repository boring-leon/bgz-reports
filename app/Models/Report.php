<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class Report extends Model
{
    public $timestamps = false;

    public $fillable = [
        'salary','rent','expenses',	'start_date','end_date'
    ];

    public function getBalanceAttribute(){
        return $this->salary - $this->expenses - $this->rent;
    }

    public function addToExpenses($amount){
        $this->update([
            'expenses' => $this->expenses + $amount,
            'balance' => $this->balance - $amount
        ]);
    }

    public function removeFromExpenses($amount){
        $this->update([
            'expenses' => $this->expenses - $amount,
            'balance' => $this->balance + $amount
        ]);
    }

    public function addToSalary($amount){
        $this->update([
            'salary' => $this->salary + $amount,
            'balance' => $this->balance + $amount
        ]);
    }

    public function removeFromSalary($amount){
        $this->update([
            'salary' => $this->salary - $amount,
            'balance' => $this->balance - $amount
        ]);
    }


    public function getDurationAttribute(){
        return Carbon::parse($this->start_date)->diffForHumans(Carbon::parse($this->end_date), CarbonInterface::DIFF_ABSOLUTE);
    }

    public function transfers(){
        return $this->hasMany(Transfer::class);
    }
}
