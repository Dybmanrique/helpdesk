<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'is_active',
        'person_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function offices()
    {
        return $this->belongsToMany(Office::class, 'administrative_users', 'user_id', 'office_id');
    }

    public function office()
    {
        return $this->hasOneThrough(
            Office::class,
            AdministrativeUser::class,
            'user_id',
            'id',
            'id',
            'office_id'
        );
    }

    public function procedures()
    {
        return $this->morphMany(Procedure::class, 'applicant');
    }

    public function derivations()
    {
        return $this->hasMany(Derivation::class, 'user_id', 'id');
    }

    public function resolutions()
    {
        return $this->hasMany(Resolution::class, 'user_id', 'id');
    }

    public function isAdmin()
    {
        return $this->offices()->exists();
    }

    public function active_procedures()
    {
        return $this->hasManyThrough(
            Procedure::class,
            Derivation::class,
            'user_id',
            'id',
            'id',
            'procedure_id'
        )->where('derivations.is_active', true);
    }
}
