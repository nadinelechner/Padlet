<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //1 User hat mehrere Ratings
    public function ratings(): HasMany {
        return $this->hasMany(Rating::class);
    }

    //1 User hat mehrere Kommentare
    public function kommentars(): HasMany {
        return $this->hasMany(Kommentar::class);
    }

    //1 User hat mehrere Einträge
    public function eintrags(): HasMany {
        return $this->hasMany(Eintrag::class);
    }

    //M:N mit Padlet
    public function padlets():BelongsToMany {
      return $this->belongsToMany(Padlet::class)->withPivot(['user_role']);
    }

    /*Beziehung zu Padlet ist N:M
    public function padlets():BelongsToMany {
        return $this->belongsToMany(Padlet::class)->withPivot(['user_role']);
    }*/

}
