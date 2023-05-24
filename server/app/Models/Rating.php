<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;
    //damit geben wir an, welche Spalten wir befüllen dürfen
    protected $fillable = ['rating'];
    use HasFactory;

    //1 Rating belongs to 1 Eintrag
    public function eintrags(): BelongsTo {
        return $this->belongsTo(Eintrag::class);
    }

    //1 Rating belongs to 1 User
    public function users(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
