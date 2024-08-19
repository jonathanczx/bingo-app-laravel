<?php

use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can be created', function () {
    $card = Card::factory()->create();
    expect($card)->toBeInstanceOf(Card::class);
});

it('can have no score', function () {
    $card = Card::factory()->create();
    expect($card->score)->toBe(null);
});

it('should increment call count on pull', function () {
    $card = Card::factory()->create();
    $card->pullNewNumber();
    expect($card->call_count)->toBe(1);
});

it('should be able to be retrieved via api route', function () {
    $card = Card::factory()->create();
    $response = $this->getJson("/api/cards/{$card->id}");
    $response->assertStatus(200);
    $response->assertJson(['card' => $card->toArray()]);
});

it('should be able to count number of marked tiles', function () {
    $card = Card::factory()->create();
    $card->tiles()->createMany([
        ['number' => 1, 'order_number' => 1, 'randomised_number' => 1,  'marked' => true],
        ['number' => 2, 'order_number' => 2, 'randomised_number' => 2,   'marked' => false],
        ['number' => 3, 'order_number' => 3, 'randomised_number' => 3,   'marked' => true],
    ]);
    expect($card->countMarkedTiles())->toBe(2);
});

it('should be able to calculate score based on call count', function () {
    $card = Card::factory()->create(['call_count' => 15]);
    $card->calculateScoreAndSave();
    expect($card->score)->toBe(100 - 15);
});

it('should be able to be created via api route', function () {
    $response = $this->postJson('/api/cards', ['name' => 'John Doe']);
    $response->assertStatus(200);
    $response->assertJson(['card' => ['name' => 'John Doe']]);
});

it('should be able to pull a new number via api route', function () {
    $card = Card::factory()->create();
    $response = $this->postJson("/api/cards/{$card->id}/pull-number");
    $response->assertStatus(200);
    $response->assertJsonStructure(['number']);
    expect($response['number'])->toBeInt();
});

it('should be able to score a card via api route', function () {
    $card = Card::factory()->create(['call_count' => 30]);
    $tiles = [];
    for ($i = 1; $i <= 25; $i++) {
        $tiles[] = ['number' => $i, 'order_number' => $i, 'randomised_number' => $i, 'marked' => true];
    }
    $card->tiles()->createMany($tiles);
    $response = $this->putJson("/api/cards/{$card->id}/score");
    $response->assertStatus(200);
    $response->assertJsonStructure(['score']);
    expect($response['score'])->toBe(100-30);
});

it('should be able to get the leaderboard for cards', function () {
    Card::factory()->count(5)->create([
        'score' => 100
    ]);
    $response = $this->getJson("/api/cards/leaderboard");
    $response->assertStatus(200);
    $response->assertJsonCount(5, 'cards');
    $response->assertJsonStructure(['cards' => [
        '*' => ['name', 'score']
    ]]);
});
