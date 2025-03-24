<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceitMatch extends Model
{
    use HasFactory;

    protected $fillable = ['match_id'];


    public function notifiedMatches()
    {
        return $this->hasMany(NotifiedMatchFaceit::class);
    }
}
