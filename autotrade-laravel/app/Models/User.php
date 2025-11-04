<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Your table is "users"
    protected $table = 'users';

    // Your table doesn't have created_at/updated_at
    public $timestamps = false;

    // Columns you actually have
    protected $fillable = [
        'display_name',
        'email',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Tell Laravel which column stores the hashed password.
     * Auth::attempt(...) will compare the submitted password with this field.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
