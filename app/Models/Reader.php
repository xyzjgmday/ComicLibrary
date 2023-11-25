<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $table = 'readers';
    public $timestamps = true;
    protected $fillable = [
        'username',
        'email',
        'password',
        'last_login',
        'api_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login',
    ];
}
