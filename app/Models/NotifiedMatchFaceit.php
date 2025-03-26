<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifiedMatchFaceit extends Model
{
    use HasFactory;

    protected $fillable = ['faceit_match_id', 'chat_id'];


    public function faceitMatch()
    {
        return $this->belongsTo(FaceitMatch::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
