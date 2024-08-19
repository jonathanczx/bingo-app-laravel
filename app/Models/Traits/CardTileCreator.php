<?php

namespace App\Models\Traits;

use App\Models\Card;
use App\Models\CardTile;

trait CardTileCreator {
    use NumberRandomiser;

    public function createTiles()
    {
        $tiles = [];
        $usedNumbers = [];
        for ($i = 1; $i <= 25; $i++) {
            $randomisedNumber = $this->randomiseNumber($usedNumbers);
            $usedNumbers[] = $randomisedNumber;

            $tiles[] = CardTile::create([
                'card_id' => $this->id,
                'order_number' => $i,
                'randomised_number' => $i == 13 ? 'FREE' : $randomisedNumber
            ]);
        }
        return $tiles; 
    }
}