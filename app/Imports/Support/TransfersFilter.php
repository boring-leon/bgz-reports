<?php

namespace App\Imports\Support;

use Illuminate\Support\Collection;

class TransfersFilter
{
    private ?Collection $data;

    public function __construct(Collection $data){
        $this->data = $data;
    }
    public function withoutInternalTransfers(){
        $count = $this->data->count();
        $this->data->each(function($row, $index) use ($count){
            if($index + 1 === $count) 
                return;
                
            if($this->shouldRemoveRows($row, $this->data->get($index + 1))){
                $this->data->forget([$index, $index+1]);
            }
        });

        return $this;
    }

    public function withoutRentTransfer($rent){
        $this->data = $this->data->filter(function($transfer) use($rent){
            return abs($transfer['kwota_zlecenia']) !== abs($rent);
        });
        return $this;
    }

    public function get(){
        return $this->data;
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