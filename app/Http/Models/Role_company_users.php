<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Role_company_users extends Model
{
    protected $table = 'role_company_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'role_id', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $timestamps = true;
}
