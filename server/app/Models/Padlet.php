<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Padlet extends Model
{
    use HasFactory;

    //functions, die der Controller brauchen könnte sind automatisch da (update zb)
    //Model gibts dann wieder an Controller weiter

    /*primary key, created_at etc werden eh automatisch befüllt
    hier gib ich an, welche Felder ich von außen befüllen darf, fillable gibt whitelist an
    guarded würd blacklist angeben*/
    protected $fillable = ['name', 'private'];

    /*da überprüft man immer ein bestimmtes Padlet, obs öffentlich ist (0=false, 1=true)*/
    public function isPrivate():bool {
        return $this->private = 0;
    }

    /*da geht man über alle Padlets drüber und es werden die ausgegeben, die öffentlich sind*/
    public static function scopePublic($query) {
        return $query->where('private', '=', 0);
    }

    /*Beziehung zu Einträge*/
    public function eintrags():HasMany{
        return $this->hasMany(Eintrag::class);
    }

    //M:N mit User
    public function user():BelongsToMany {
      return $this->belongsToMany(User::class)->withPivot(['user_role']);
    }

    /*App\Models\Padlet::public()->get() - so gibt mans im tinker ein
    scope ist nur für Laravel eine Konvention*/
    /*sonstige Befehle fürn tinker:
    $padlet->name = 'Name wird geändert'; Ausgabe ist dann der neue Name: 'Name wird geändert
    $padlet_save(); -'
    $padlet->delete()
    $padlet->updateOrCreate, firstOrCreate...etc*/
}
