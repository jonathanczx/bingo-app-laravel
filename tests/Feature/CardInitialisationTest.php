<?php

use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should have 25 tiles on a card', function () {
    $card = Card::factory()->create();
    $tiles = $card->createTiles();

    expect($card->tiles()->count())->toBe(25);
});

it('13th Card should be FREE', function () {
    $card = Card::factory()->create();
    $tiles = $card->createTiles();
    $freeTile = $card->tiles()->where('order_number', 13)->first();
    expect($freeTile->randomised_number)->toBe('FREE');
});

it('Card should have unique randomised numbers', function () {
    $card = Card::factory()->create();
    $tiles = $card->createTiles();
    $randomisedNumbers = $card->tiles()->pluck('randomised_number')->toArray();
    expect(count($randomisedNumbers))->toBe(count(array_unique($randomisedNumbers)));
});
