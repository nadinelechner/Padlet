<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kommentar extends Model
{
    use HasFactory;
    //damit geben wir an, welche Spalten wir befüllen dürfen
    protected $fillable = ['text'];
    use HasFactory;

    //1 Kommentar belong to 1 Eintrag
    public function eintrags(): BelongsTo {
        return $this->belongsTo(Eintrag::class);
    }

    //1 Kommentar belong to 1 User
    public function users(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
