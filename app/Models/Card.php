<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CardTileCreator;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory,
        CardTileCreator;

    protected $fillable = [
        'name',
        'score',
        'call_count'
    ];

    /**
     * Tiles relationship
     * 
     * @return HasMany 
     */
    public function tiles() : HasMany
    {
        return $this->hasMany(CardTile::class);
    }

    /**
     * Pulled numbers relationship
     * 
     * @return HasMany 
     */
    public function pulledNumbers() : HasMany
    {
        return $this->hasMany(PulledNumber::class);
    }

    /**
     * Pull a random number
     * 
     * @return CardTile
     */
    public function pullNewNumber() : int
    {
        $number = $this->randomiseNumber(
            $this->pulledNumbers
                ->pluck('number')
                ->toArray()
        );

        $this->pulledNumbers()->create([
            'number' => $number
        ]);

        $this->increment('call_count');

        return $number;   
    }

    public function countMarkedTiles() : int
    {
        return $this->tiles->where('marked', true)->count();
    }

    public function calculateScoreAndSave() : int
    {
        $this->score = abs(100 - $this->call_count);
        $this->save();
        
        return $this->score;
    }
}
