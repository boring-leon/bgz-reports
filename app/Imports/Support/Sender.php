<?php

namespace App\Imports\Support;

class Sender
{
    private $senderArr;
    
    public function __construct($row){
        $this->senderArr = explode("\n", $row['nadawca_odbiorca']);
    }

    public function accountNumber(){
        return array_key_exists(0, $this->senderArr) 
            ? filter_var($this->senderArr[0], FILTER_SANITIZE_NUMBER_INT)
            : null;
    }

    public function name(){
        return array_key_exists(1, $this->senderArr) 
                ? mb_strtoupper($this->senderArr[1]) 
                : null;
    }
    
    public static function build($row){
        return new self($row);
    }
}