<?php

use App\Models\Card;
use App\Models\CardTile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can be created', function () {
    $card = Card::factory()->create();
    $cardTile = CardTile::factory()->create([
        'card_id' => $card->id,
        'order_number' => 1,
        'randomised_number' => random_int(1,100),
    ]);
    expect($cardTile)->not->toBe(null);
});

it('can be marked as completed', function () {
    $card = Card::factory()->create();
    $cardTile = CardTile::factory()->create([
        'card_id' => $card->id,
        'order_number' => 1,
        'randomised_number' => random_int(1,100),
    ]);
    $cardTile->markTile();
    expect($cardTile->marked)->toBe(true);
});

