<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class Report extends Model
{
    public $timestamps = false;

    public $fillable = [
        'salary','rent','expenses',	'start_date','end_date', 'name'
    ];

    public function getBalanceAttribute(){
        return $this->salary - $this->expenses - $this->rent;
    }

    public function getHumanDurationAttribute(){
        return Carbon::parse($this->start_date)->diffForHumans(Carbon::parse($this->end_date), CarbonInterface::DIFF_ABSOLUTE);
    }

    public function getDaysDurationAttribute(){
        return Carbon::createFromDate($this->start_date)->diffInDays(Carbon::createFromDate($this->end_date));
    }

    public function transfers(){
        return $this->hasMany(Transfer::class);
    }
}
