<?php

namespace App\Imports\Support;

use Illuminate\Support\Collection;

class TransfersFilter
{
    public function withoutInternal(Collection $transfers){
        $count = $transfers->count();
        $transfers->each(function($row, $index) use ($transfers, $count){
            if($index + 1 === $count) 
                return;
                
            if($this->shouldRemoveRows($row, $transfers->get($index + 1))){
                $transfers->forget([$index, $index+1]);
            }
        });

        return $transfers;
    }

    private function shouldRemoveRows($row1, $row2){
        return 
            $this->isOppositeAmount($row1,$row2) &&
            $this->isSameSenderName($row1, $row2) &&
            $this->accountsBelongToUser($row1, $row2);
    }

    private function isOppositeAmount($row1, $row2){
        return abs($row1['kwota']) === abs($row2['kwota']);
    }

    private function isSameSenderName($row1, $row2){
        return Sender::build($row1)->name() === Sender::build($row2)->name();
    }

    private function accountsBelongToUser($row1, $row2){
        $accounts = ["12160014621831584860000002", "39160014621831584860000001"];
        return 
            in_array(Sender::build($row1)->accountNumber(), $accounts) && 
            in_array(Sender::build($row2)->accountNumber(), $accounts);
    }
}