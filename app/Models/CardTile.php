<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTile extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'order_number',
        'randomised_number',
        'marked'
    ];

    public function markTile()
    {
        $this->marked = true;
        $this->save();
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
