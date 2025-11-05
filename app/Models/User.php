<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable = ['role','name','email','password_hash'];

    // important for legacy tables without created_at/updated_at
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
