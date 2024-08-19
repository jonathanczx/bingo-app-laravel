<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardTile;

class CardTileController extends Controller
{
    public function markNumber(Card $card, CardTile $cardTile)
    {
        if($cardTile->marked) {
            return response()->json([
                'message' => 'Number already marked'
            ], 400);
        } else {
            // check if card tile number is in pulled numbers before marking
            $cardTileNumber = $cardTile->randomised_number;
            $pulledNumbers = $card->pulledNumbers->pluck('number')->toArray();
            if(in_array($cardTileNumber, $pulledNumbers) || $cardTileNumber == 'FREE') {
                $cardTile->update([
                    'marked' => true
                ]);
                return response()->json([
                    'message' => 'Number marked',
                ]);
            } else {
                return response()->json([
                    'message' => 'Number not pulled'
                ], 400);
            }
        }
    }
}