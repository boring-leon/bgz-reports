<?php

namespace App\Observers;

use App\Models\Transfer;

class TransferObserver
{
    public function created(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->addToSalary($transfer->kwota);
        else
            $transfer->report->addToExpenses($transfer->kwota);
    }   

    public function updated(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->addToSalary($transfer->kwota);
        else
            $transfer->report->addToExpenses($transfer->kwota);
    }

    public function deleted(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->removeFromSalary($transfer->kwota);
        else
            $transfer->report->removeFromExpenses($transfer->kwota);
    }
}
