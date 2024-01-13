<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $table = 'readers';

    protected $fillable = [
        'username',
        'email',
        'password',
        'last_login',
        'api_token',
    ];

    protected $dates = [
        'last_login'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value ? date('d-m-Y H:i:s', strtotime($value)) : null;
    }

}
