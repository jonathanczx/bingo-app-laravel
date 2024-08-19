<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PulledNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'card_id'
    ];

    /**
     * Card relationship
     * 
     * @return BelongsTo 
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
