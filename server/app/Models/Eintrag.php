<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eintrag extends Model
{
    //damit geben wir an, welche Spalten wir befüllen dürfen
    protected $fillable = ['text', 'user_id', 'padlet_id'];

    use HasFactory;

    //1 Eintrag gehört zu 1 Padlet
    public function padlets(): BelongsTo {
        return $this->belongsTo(Padlet::class);
    }

    //1 Eintrag hat mehrere Ratings
    public function ratings(): HasMany {
        return $this->hasMany(Rating::class);
    }

    //1 Eintrag hat mehrere Kommentare
    public function kommentars(): HasMany {
        return $this->hasMany(Kommentar::class);
    }

    //1 Eintrag gehört zu 1 User
    public function users(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
