<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_admins',
        'password_admins',
        'password_confirm',
    ];

    protected $table = 'admin';

    protected $hidden = [
        'password_admins',
        'password_confirm',
        'remember_token',
    ];

    
    public function setPasswordAdminsAttribute($password)
    {
        $this->attributes['password_admins'] = Hash::make($password);
    }

    
    public function setPasswordConfirmAttribute($password)
    {
        $this->attributes['password_confirm'] = Hash::make($password);
    }
}
