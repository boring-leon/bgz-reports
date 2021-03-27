<?php

namespace App\Observers;

use App\Models\Transfer;

class TransferObserver
{
    public function created(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->increment('salary', $transfer->kwota);
        else
            $transfer->report->increment('expenses', abs($transfer->kwota));
    }   

    public function updated(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->increment('salary', $transfer->kwota);
        else
            $transfer->report->increment('expenses', abs($transfer->kwota));
    }

    public function deleted(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->decrement('salary', $transfer->kwota);
        else
            $transfer->report->decrement('expenses', abs($transfer->kwota));
    }
}
