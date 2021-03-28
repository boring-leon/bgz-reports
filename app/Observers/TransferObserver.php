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

        $this->updateReportDate($transfer);
    }   

    public function updated(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->increment('salary', $transfer->kwota);
        else
            $transfer->report->increment('expenses', abs($transfer->kwota));

        $this->updateReportDate($transfer);
    }

    public function deleted(Transfer $transfer){
        if($transfer->kwota > 0)
            $transfer->report->decrement('salary', $transfer->kwota);
        else
            $transfer->report->decrement('expenses', abs($transfer->kwota));

        $this->updateReportDate($transfer);
    }

    private function updateReportDate(Transfer $transfer){
        $otherTransfersWithDate = $transfer->report->transfers()->where('data_zlecenia_operacji', $transfer->data_zlecenia_operacji)->where('id','!=',$transfer->id);

        if($transfer->data_zlecenia_operacji == $transfer->report->start_date && $otherTransfersWithDate->doesntExist()){
            $transfer->report->syncStartDateWithTransfers();
        }
        else if($transfer->data_zlecenia_operacji == $transfer->report->end_date && $otherTransfersWithDate->doesntExist()){
            $transfer->report->syncEndDateWithTransfers();
        }
    }
}
