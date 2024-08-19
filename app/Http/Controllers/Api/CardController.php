<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewCardRequest;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;

class CardController extends Controller
{

    public function show(Card $card)
    {
        $card->load('tiles');

        return response()->json([
            'card' => $card,
        ]);
    }

    public function store(NewCardRequest $request)
    {
        $name = $request->get('name');
        $card = Card::create(['name' => $name]);
        $card->createTiles();
        
        return response()->json([
            'card' => $card
        ]);
    }

    public function pullNumber(Card $card)
    {
        try {
            $number = $card->pullNewNumber();
            return response()->json([
                'number' => $number
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function score(Card $card)
    {
        if($card->countMarkedTiles() == 25) {
            $score = $card->calculateScoreAndSave();
            return response()->json([
                'score' => $score
            ]);
        } else {
            return response()->json([
                'message' => 'Card not complete'
            ], 400);
        }
    }

    public function leaderboard()
    {
        $cards = Card::query()
            ->whereNotNull('score')
            ->orderBy('score', 'desc')
            ->limit(10)
            ->get(['name', 'score']);
        return response()->json([
            'cards' => $cards
        ]);
    }
}