<?php

namespace App\Models\Traits;

use Exception;

trait NumberRandomiser
{
    /**
     * Randomise a number
     * 
     * @param array $except 
     * @return int 
     * @throws RandomException 
     */
    public function randomiseNumber($except = []) : int
    {
        $number = random_int(1, 100);
        if(count($except) === 100) {
            throw new Exception('All numbers have been pulled');
        }

        return in_array($number, $except) ? $this->randomiseNumber($except) : $number;
    }
}